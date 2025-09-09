<?php
require_once __DIR__ . '/../src/db.php';

// Step 1: Fetch all LGAs in Delta
$stmt = $pdo->prepare("SELECT uniqueid, lga_name FROM lga WHERE state_id = 25 ORDER BY lga_name");
$stmt->execute();
$lgas = $stmt->fetchAll();

// If user selected a polling unit, fetch its results
$results = [];
if (isset($_GET['pu_id']) && $_GET['pu_id'] !== '') {
    $pu_id = $_GET['pu_id'];
    $stmt = $pdo->prepare("SELECT party_abbreviation, party_score 
                           FROM announced_pu_results 
                           WHERE polling_unit_uniqueid = ?");
    $stmt->execute([$pu_id]);
    $results = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Polling Unit Results</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-2xl p-6">
    <h1 class="text-2xl font-bold mb-4">Polling Unit Results (Delta State)</h1>

    <!-- Form for selection -->
    <form method="GET" class="space-y-4">
      <!-- LGA select -->
      <div>
        <label class="block font-medium mb-1">Select LGA</label>
        <select id="lga" name="lga_id" class="w-full border rounded p-2">
          <option value="">-- Choose LGA --</option>
          <?php foreach ($lgas as $lga): ?>
            <option value="<?= $lga['uniqueid'] ?>"
              <?= (isset($_GET['lga_id']) && $_GET['lga_id'] == $lga['uniqueid']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($lga['lga_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Ward select (loaded dynamically via JS) -->
      <div>
        <label class="block font-medium mb-1">Select Ward</label>
        <select id="ward" name="ward_id" class="w-full border rounded p-2">
          <option value="">-- Choose Ward --</option>
        </select>
      </div>

      <!-- Polling Unit select -->
      <div>
        <label class="block font-medium mb-1">Select Polling Unit</label>
        <select id="pu" name="pu_id" class="w-full border rounded p-2">
          <option value="">-- Choose Polling Unit --</option>
        </select>
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Show Results
      </button>
    </form>

    <!-- Results table -->
    <?php if ($results): ?>
      <h2 class="text-xl font-semibold mt-6 mb-3">Results</h2>
      <table class="w-full border border-collapse">
        <thead>
          <tr class="bg-gray-200">
            <th class="border px-4 py-2 text-left">Party</th>
            <th class="border px-4 py-2 text-right">Score</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $row): ?>
            <tr>
              <td class="border px-4 py-2"><?= htmlspecialchars($row['party_abbreviation']) ?></td>
              <td class="border px-4 py-2 text-right"><?= htmlspecialchars($row['party_score']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php elseif (isset($_GET['pu_id'])): ?>
      <p class="mt-6 text-red-600">No results found for this polling unit.</p>
    <?php endif; ?>
  </div>

  <!-- Chained select logic -->
  <script>
    const wardSelect = document.getElementById('ward');
    const puSelect   = document.getElementById('pu');
    const lgaSelect  = document.getElementById('lga');

    lgaSelect.addEventListener('change', async () => {
      const lgaId = lgaSelect.value;
      wardSelect.innerHTML = '<option value="">-- Choose Ward --</option>';
      puSelect.innerHTML   = '<option value="">-- Choose Polling Unit --</option>';
      if (!lgaId) return;

      const res = await fetch('../src/ajax.php?action=getWards&lga_id=' + lgaId);
      const wards = await res.json();
      wards.forEach(w => {
        wardSelect.innerHTML += `<option value="${w.uniqueid}">${w.ward_name}</option>`;
      });
    });

    wardSelect.addEventListener('change', async () => {
      const wardId = wardSelect.value;
      puSelect.innerHTML = '<option value="">-- Choose Polling Unit --</option>';
      if (!wardId) return;

      const res = await fetch('../src/ajax.php?action=getPUs&ward_id=' + wardId);
      const pus = await res.json();
      pus.forEach(p => {
        puSelect.innerHTML += `<option value="${p.uniqueid}">${p.polling_unit_name}</option>`;
      });
    });
  </script>
</body>
</html>