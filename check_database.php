<?php
// Simple database check without PDO
echo "<h1>Database Check</h1>";

// Check if we can connect to MySQL
$host = '127.0.0.1';
$user = 'root';
$pass = '';

echo "<h2>1. MySQL Connection Test</h2>";
$connection = @mysqli_connect($host, $user, $pass);

if ($connection) {
    echo "<p style='color: green;'>✓ MySQL connection successful!</p>";
    
    // Check if database exists
    $db_check = mysqli_select_db($connection, 'bincomphptest');
    if ($db_check) {
        echo "<p style='color: green;'>✓ Database 'bincomphptest' exists!</p>";
        
        // Check tables
        $tables = ['lga', 'ward', 'polling_unit', 'announced_pu_results'];
        foreach ($tables as $table) {
            $result = mysqli_query($connection, "SHOW TABLES LIKE '$table'");
            if (mysqli_num_rows($result) > 0) {
                echo "<p style='color: green;'>✓ Table '$table' exists</p>";
                
                // Count records
                $count_result = mysqli_query($connection, "SELECT COUNT(*) as count FROM $table");
                $count = mysqli_fetch_assoc($count_result)['count'];
                echo "<p>&nbsp;&nbsp;&nbsp;→ $count records</p>";
            } else {
                echo "<p style='color: red;'>✗ Table '$table' missing</p>";
            }
        }
        
        // Test specific query
        echo "<h2>2. Sample Data Test</h2>";
        $result = mysqli_query($connection, "SELECT lga_name FROM lga WHERE state_id = 25 LIMIT 5");
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<p style='color: green;'>✓ Sample LGAs found:</p>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p>&nbsp;&nbsp;&nbsp;→ " . $row['lga_name'] . "</p>";
            }
        }
        
    } else {
        echo "<p style='color: red;'>✗ Database 'bincomphptest' not found!</p>";
        echo "<p><strong>Solution:</strong> Import the SQL dump first</p>";
    }
    
    mysqli_close($connection);
} else {
    echo "<p style='color: red;'>✗ MySQL connection failed!</p>";
    echo "<p><strong>Error:</strong> " . mysqli_connect_error() . "</p>";
    echo "<p><strong>Solutions:</strong></p>";
    echo "<ul>";
    echo "<li>Make sure MySQL is running</li>";
    echo "<li>Check if MySQL is on port 3306</li>";
    echo "<li>Verify username/password</li>";
    echo "</ul>";
}

echo "<h2>3. Next Steps</h2>";
echo "<p>If everything is green above, you can test the application:</p>";
echo "<ul>";
echo "<li><a href='public/show_polling_unit.php'>Open Polling Unit Results Page</a></li>";
echo "<li>Or run: <code>php -S localhost:8000</code> and visit <code>http://localhost:8000/public/show_polling_unit.php</code></li>";
echo "</ul>";
?>
