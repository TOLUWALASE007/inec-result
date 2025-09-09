<?php
// Debug script to check Railway environment
header('Content-Type: application/json');

echo json_encode([
    'port_env' => $_ENV['PORT'] ?? 'NOT SET',
    'port_getenv' => getenv('PORT') ?: 'NOT SET',
    'all_env' => $_ENV,
    'server_port' => $_SERVER['SERVER_PORT'] ?? 'NOT SET',
    'server_name' => $_SERVER['SERVER_NAME'] ?? 'NOT SET',
    'http_host' => $_SERVER['HTTP_HOST'] ?? 'NOT SET',
    'request_uri' => $_SERVER['REQUEST_URI'] ?? 'NOT SET'
]);
?>
