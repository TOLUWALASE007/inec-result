<?php
// src/db.php - Works for both local and Railway deployment

// Check if we're on Railway (has MYSQL_HOST) or local development
if (isset($_ENV['MYSQL_HOST']) || isset($_ENV['DATABASE_URL'])) {
    // Railway deployment
    $host = $_ENV['MYSQL_HOST'] ?? 'localhost';
    $db   = $_ENV['MYSQL_DATABASE'] ?? 'railway';
    $user = $_ENV['MYSQL_USER'] ?? 'root';
    $pass = $_ENV['MYSQL_PASSWORD'] ?? '';
    
    // Handle Railway's MySQL URL format if provided
    if (isset($_ENV['DATABASE_URL'])) {
        $url = parse_url($_ENV['DATABASE_URL']);
        $host = $url['host'] ?? $host;
        $db = ltrim($url['path'] ?? '', '/') ?: $db;
        $user = $url['user'] ?? $user;
        $pass = $url['pass'] ?? $pass;
    }
} else {
    // Local development
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $db   = getenv('DB_NAME') ?: 'bincomphptest';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';
}

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
