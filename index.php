<?php
// Main entry point for Vercel
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Simple response
echo json_encode([
    'status' => 'success',
    'message' => 'INEC Results Portal Backend is running on Vercel!',
    'php_version' => phpversion(),
    'server_time' => date('Y-m-d H:i:s'),
    'frontend' => 'https://toluwalase007.github.io/inec-result',
    'endpoints' => [
        'health' => '/api/health.php',
        'test' => '/api/test.php',
        'question1' => '/api/question1.php',
        'question2' => '/api/question2.php', 
        'question3' => '/api/question3.php'
    ]
]);
?>