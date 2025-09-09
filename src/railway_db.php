<?php
// Railway-specific database configuration
// This file handles Railway's environment variables

// Get Railway environment variables
$host = $_ENV['MYSQL_HOST'] ?? $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['MYSQL_DATABASE'] ?? $_ENV['DB_NAME'] ?? 'railway';
$user = $_ENV['MYSQL_USER'] ?? $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['MYSQL_PASSWORD'] ?? $_ENV['DB_PASS'] ?? '';

// Handle Railway's MySQL URL format if provided
if (isset($_ENV['DATABASE_URL'])) {
    $url = parse_url($_ENV['DATABASE_URL']);
    $host = $url['host'] ?? $host;
    $db = ltrim($url['path'] ?? '', '/') ?: $db;
    $user = $url['user'] ?? $user;
    $pass = $url['pass'] ?? $pass;
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
    die("Database connection failed: " . $e->getMessage());
}
