<?php
// test_connection.php - Simple database connection test
require_once 'src/db.php';

echo "<h1>Database Connection Test</h1>";

try {
    // Test basic connection
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Test query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM lga WHERE state_id = 25");
    $result = $stmt->fetch();
    echo "<p>✓ Found {$result['count']} LGAs in Delta State</p>";
    
    // Test polling units
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM polling_unit");
    $result = $stmt->fetch();
    echo "<p>✓ Found {$result['count']} polling units in database</p>";
    
    // Test results
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM announced_pu_results");
    $result = $stmt->fetch();
    echo "<p>✓ Found {$result['count']} result records in database</p>";
    
    echo "<p style='color: green; font-weight: bold;'>All tests passed! The application should work correctly.</p>";
    echo "<p><a href='public/index.php'>Go to Application</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database configuration in src/db.php</p>";
}
?>
