<?php
// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    require_once '../../src/db.php';
    
    // Test database connection
    $stmt = $pdo->query("SELECT 1");
    
    // Get some basic stats
    $lgaCount = $pdo->query("SELECT COUNT(*) FROM lga WHERE state_id = 25")->fetchColumn();
    $puCount = $pdo->query("SELECT COUNT(*) FROM polling_unit")->fetchColumn();
    $resultCount = $pdo->query("SELECT COUNT(*) FROM announced_pu_results")->fetchColumn();
    
    echo json_encode([
        'status' => 'success',
        'message' => 'INEC Results Portal Backend is running',
        'database' => 'connected',
        'stats' => [
            'lgas' => (int)$lgaCount,
            'polling_units' => (int)$puCount,
            'results' => (int)$resultCount
        ],
        'endpoints' => [
            'health' => '/api/health.php',
            'question1' => '/show_polling_unit.php',
            'question2' => '/show_lga_sum.php',
            'question3' => '/add_polling_unit.php'
        ],
        'timestamp' => date('Y-m-d H:i:s')
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed',
        'error' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}
