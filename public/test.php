<?php
// Simple test file for Railway deployment
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

echo json_encode([
    'status' => 'success',
    'message' => 'PHP is working on Railway!',
    'php_version' => phpversion(),
    'extensions' => [
        'pdo' => extension_loaded('pdo'),
        'pdo_mysql' => extension_loaded('pdo_mysql'),
        'json' => extension_loaded('json')
    ],
    'timestamp' => date('Y-m-d H:i:s'),
    'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'
]);
?>
