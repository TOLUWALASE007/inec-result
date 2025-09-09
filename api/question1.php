<?php
// Vercel API endpoint - Question 1: Individual Polling Unit Results
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// For now, return a simple response
// Later we'll add database connection
echo json_encode([
    'status' => 'success',
    'message' => 'Question 1: Individual Polling Unit Results',
    'description' => 'This endpoint will show results for any individual polling unit',
    'implementation' => 'Coming soon - will connect to database',
    'endpoint' => '/api/question1.php'
]);
?>
