<?php
// Force CORS headers using a different approach
// This file will be served directly by Railway

// Remove any existing output
if (ob_get_level()) {
    ob_end_clean();
}

// Set CORS headers before any output
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 86400');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Return JSON response
$response = [
    'status' => 'success',
    'message' => 'CORS headers forced successfully!',
    'php_version' => phpversion(),
    'server_time' => date('Y-m-d H:i:s'),
    'request_method' => $_SERVER['REQUEST_METHOD'],
    'headers_sent' => headers_sent(),
    'cors_origin' => $_SERVER['HTTP_ORIGIN'] ?? 'No Origin header'
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>
