<?php
// Railway entry point
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'status' => 'success',
    'message' => 'INEC Results Portal Backend is running',
    'frontend' => 'https://toluwalase007.github.io/inec-result',
    'endpoints' => [
        'health' => '/api/health.php',
        'test' => '/test.php',
        'question1' => '/show_polling_unit.php',
        'question2' => '/show_lga_sum.php',
        'question3' => '/add_polling_unit.php'
    ],
    'timestamp' => date('Y-m-d H:i:s')
]);
?>