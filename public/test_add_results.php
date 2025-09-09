<?php
require_once __DIR__ . '/../src/db.php';

// Test data for polling unit 8
$test_data = [
    'pu_id' => '8',
    'entered_by_user' => 'test_user',
    'scores' => [
        'PDP' => 100,
        'DPP' => 80,
        'ACN' => 60,
        'PPA' => 40,
        'CDC' => 30,
        'JP' => 20,
        'ANPP' => 15,
        'LABOUR' => 10,
        'CPP' => 5
    ]
];

echo "<h1>Test Add Results</h1>";

// Simulate form submission
$_POST = $test_data;
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

$pu_id = $_POST['pu_id'] ?? null;
$entered_by = $_POST['entered_by_user'] ?? 'admin';
$ip = $_SERVER['REMOTE_ADDR'];

if ($pu_id && !empty($_POST['scores'])) {
    $pdo->beginTransaction();
    try {
        // First, delete existing results for this polling unit
        $deleteStmt = $pdo->prepare("DELETE FROM announced_pu_results WHERE polling_unit_uniqueid = ?");
        $deleteStmt->execute([$pu_id]);
        
        // Insert new results
        $stmt = $pdo->prepare("
            INSERT INTO announced_pu_results
            (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address)
            VALUES (?, ?, ?, ?, NOW(), ?)
        ");
        
        foreach ($_POST['scores'] as $party => $score) {
            $stmt->execute([$pu_id, $party, $score ?: 0, $entered_by, $ip]);
        }
        
        $pdo->commit();
        echo "<p style='color: green;'>✓ Test results successfully stored!</p>";
        
        // Verify the results
        $verifyStmt = $pdo->prepare("SELECT party_abbreviation, party_score FROM announced_pu_results WHERE polling_unit_uniqueid = ? ORDER BY party_score DESC");
        $verifyStmt->execute([$pu_id]);
        $results = $verifyStmt->fetchAll();
        
        echo "<h2>Stored Results:</h2>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Party</th><th>Score</th></tr>";
        foreach ($results as $result) {
            echo "<tr><td>{$result['party_abbreviation']}</td><td>{$result['party_score']}</td></tr>";
        }
        echo "</table>";
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Missing data</p>";
}

echo "<p><a href='show_polling_unit.php?pu_id=8'>View Results in Main App</a></p>";
echo "<p><a href='add_polling_unit.php'>Go to Add Results Form</a></p>";
?>
