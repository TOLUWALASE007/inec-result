<?php
// Basic test endpoint - plain text response
// Start output buffering to ensure headers are sent first
ob_start();

// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 86400');
header('Content-Type: text/plain');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    ob_end_flush();
    exit();
}

echo "Railway PHP server is working!\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Server Time: " . date('Y-m-d H:i:s') . "\n";
echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "\n";

// Flush output buffer
ob_end_flush();
?>
