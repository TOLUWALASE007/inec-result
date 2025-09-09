<?php
// Quick test to check if everything is working
echo "<h1>INEC Results Portal - Quick Test</h1>";

// Test 1: Check if database file exists
echo "<h2>1. Database Connection Test</h2>";
try {
    require_once 'src/db.php';
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Test basic query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM lga WHERE state_id = 25");
    $result = $stmt->fetch();
    echo "<p>✓ Found {$result['count']} LGAs in Delta State</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Solution:</strong> Make sure you've imported the SQL dump and configured database credentials.</p>";
}

// Test 2: Check if files exist
echo "<h2>2. File Structure Test</h2>";
$files_to_check = [
    'public/show_polling_unit.php',
    'src/ajax.php',
    'src/db.php',
    'sql/bincom_test.sql'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✓ $file exists</p>";
    } else {
        echo "<p style='color: red;'>✗ $file missing</p>";
    }
}

// Test 3: Check AJAX endpoint
echo "<h2>3. AJAX Endpoint Test</h2>";
if (file_exists('src/ajax.php')) {
    echo "<p style='color: green;'>✓ AJAX endpoint ready</p>";
    echo "<p><a href='src/ajax.php?action=getWards&lga_id=1' target='_blank'>Test AJAX endpoint</a></p>";
} else {
    echo "<p style='color: red;'>✗ AJAX endpoint missing</p>";
}

echo "<h2>4. Next Steps</h2>";
echo "<p><strong>If database connection works:</strong></p>";
echo "<ul>";
echo "<li><a href='public/show_polling_unit.php' target='_blank'>Test Polling Unit Results Page</a></li>";
echo "<li>Select an LGA → Ward → Polling Unit → View Results</li>";
echo "</ul>";

echo "<p><strong>If database connection fails:</strong></p>";
echo "<ul>";
echo "<li>Import the SQL dump: <code>mysql -u root -p bincomphptest < sql/bincom_test.sql</code></li>";
echo "<li>Update database credentials in <code>src/db.php</code></li>";
echo "</ul>";
?>
