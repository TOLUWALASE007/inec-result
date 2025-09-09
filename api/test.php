<?php
// Vercel API endpoint - Test
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo json_encode([
    'status' => 'success',
    'message' => 'Vercel PHP API is working!',
    'php_version' => phpversion(),
    'server_time' => date('Y-m-d H:i:s')
]);
?>
