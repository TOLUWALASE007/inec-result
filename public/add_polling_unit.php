<?php
// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

require_once __DIR__ . '/../src/db.php';

// Fetch LGAs (Delta)
$stmt = $pdo->prepare("SELECT uniqueid, lga_name FROM lga WHERE state_id = 25 ORDER BY lga_name");
$stmt->execute();
$lgas = $stmt->fetchAll();

// Fetch parties
$stmt = $pdo->query("SELECT partyid, partyname FROM party ORDER BY partyid");
$parties = $stmt->fetchAll();

// Handle form submit
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pu_id = $_POST['pu_id'] ?? null;
    $entered_by = $_POST['entered_by_user'] ?? 'admin';
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($pu_id && !empty($_POST['scores'])) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("
                INSERT INTO announced_pu_results
                (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address)
                VALUES (?, ?, ?, ?, NOW(), ?)
            ");
            foreach ($_POST['scores'] as $party => $score) {
                $stmt->execute([$pu_id, $party, $score ?: 0, $entered_by, $ip]);
            }
            $pdo->commit();
            $message = "Results successfully stored!";
        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please select a polling unit and enter scores.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Polling Unit Results</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-2xl p-6">
    <h1 class="text-2xl font-bold mb-4">Add New Polling Unit Results</h1>

    <?php if ($message): ?>
      <div class="mb-4 p-3 rounded <?= strpos($message, 'Error') === false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" class="space-y-4">
      <!-- User entry -->
      <div>
        <label class="block font-medium mb-1">Entered By</label>
        <input type="text" name="entered_by_user" class="w-full border rounded p-2" value="admin" required>
      </div>

      <!-- LGA Select -->
      <div>
        <label class="block font-medium mb-1">Select LGA</label>
        <select id="lga" name="lga_id" class="w-full border rounded p-2" required>
          <option value="">-- Choose LGA --</option>
          <?php foreach ($lgas as $lga): ?>
            <option value="<?= $lga['uniqueid'] ?>"><?= htmlspecialchars($lga['lga_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Ward Select -->
      <div>
        <label class="block font-medium mb-1">Select Ward</label>
        <select id="ward" name="ward_id" class="w-full border rounded p-2" required>
          <option value="">-- Choose Ward --</option>
        </select>
      </div>

      <!-- Polling Unit Select -->
      <div>
        <label class="block font-medium mb-1">Select Polling Unit</label>
        <select id="pu" name="pu_id" class="w-full border rounded p-2" required>
          <option value="">-- Choose Polling Unit --</option>
        </select>
      </div>

      <!-- Party Scores -->
      <h2 class="text-xl font-semibold mt-4">Enter Scores</h2>
      <div class="grid grid-cols-2 gap-4">
        <?php foreach ($parties as $party): ?>
          <div>
            <label class="block font-medium"><?= htmlspecialchars($party['partyid']) ?></label>
            <input type="number" name="scores[<?= $party['partyid'] ?>]" class="w-full border rounded p-2" min="0" value="0">
          </div>
        <?php endforeach; ?>
      </div>

      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
        Save Results
      </button>
    </form>
  </div>

  <!-- Chained select JS -->
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