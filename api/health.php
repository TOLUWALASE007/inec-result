<?php
// Vercel API endpoint - Health check
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo json_encode([
    'status' => 'success',
    'message' => 'Vercel PHP API is healthy!',
    'php_version' => phpversion(),
    'server_time' => date('Y-m-d H:i:s'),
    'platform' => 'Vercel'
]);
?>
