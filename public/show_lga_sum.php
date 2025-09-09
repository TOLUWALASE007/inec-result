<?php
require_once __DIR__ . '/../src/db.php';

// Fetch all LGAs in Delta
$stmt = $pdo->prepare("SELECT uniqueid, lga_name FROM lga WHERE state_id = 25 ORDER BY lga_name");
$stmt->execute();
$lgas = $stmt->fetchAll();

// If an LGA is chosen, compute summed results
$results = [];
$lga_name = '';
if (isset($_GET['lga_id']) && $_GET['lga_id'] !== '') {
    $lga_id = $_GET['lga_id'];

    // Get LGA name for display
    $stmt = $pdo->prepare("SELECT lga_name FROM lga WHERE uniqueid = ?");
    $stmt->execute([$lga_id]);
    $lga_name = $stmt->fetchColumn();

    // Get summed results - using a different approach to avoid collation issues
    $stmt = $pdo->prepare("
        SELECT apr.party_abbreviation, SUM(apr.party_score) AS total_score
        FROM announced_pu_results apr
        WHERE apr.polling_unit_uniqueid IN (
            SELECT CONCAT(pu.uniqueid) 
            FROM polling_unit pu 
            WHERE pu.lga_id = ?
        )
        GROUP BY apr.party_abbreviation
        ORDER BY total_score DESC
    ");
    $stmt->execute([$lga_id]);
    $results = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LGA Summed Results</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-2xl p-6">
    <h1 class="text-2xl font-bold mb-4">Summed LGA Results (Delta State)</h1>

    <!-- Select LGA form -->
    <form method="GET" class="mb-6">
      <label class="block font-medium mb-1">Select Local Government</label>
      <select name="lga_id" class="w-full border rounded p-2 mb-4">
        <option value="">-- Choose LGA --</option>
        <?php foreach ($lgas as $lga): ?>
          <option value="<?= $lga['uniqueid'] ?>"
            <?= (isset($_GET['lga_id']) && $_GET['lga_id'] == $lga['uniqueid']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($lga['lga_name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Show Results
      </button>
    </form>

    <!-- Results Table -->
    <?php if ($results): ?>
      <h2 class="text-xl font-semibold mb-3">Results for <?= htmlspecialchars($lga_name) ?></h2>
      <table class="w-full border border-collapse">
        <thead>
          <tr class="bg-gray-200">
            <th class="border px-4 py-2 text-left">Party</th>
            <th class="border px-4 py-2 text-right">Total Score</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $row): ?>
            <tr>
              <td class="border px-4 py-2"><?= htmlspecialchars($row['party_abbreviation']) ?></td>
              <td class="border px-4 py-2 text-right"><?= htmlspecialchars($row['total_score']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php elseif (isset($_GET['lga_id'])): ?>
      <p class="mt-6 text-red-600">No results found for this LGA.</p>
    <?php endif; ?>
  </div>
</body>
</html>