<?php
// Main entry point for Railway - handles all requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get the requested path
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Remove leading slash
$path = ltrim($path, '/');

// Route requests
switch ($path) {
    case '':
    case 'index.php':
        // Main API endpoint
        echo json_encode([
            'status' => 'success',
            'message' => 'INEC Results Portal Backend is running!',
            'frontend' => 'https://toluwalase007.github.io/inec-result',
            'endpoints' => [
                'health' => '/api/health.php',
                'test' => '/test.php',
                'question1' => '/show_polling_unit.php',
                'question2' => '/show_lga_sum.php',
                'question3' => '/add_polling_unit.php'
            ],
            'timestamp' => date('Y-m-d H:i:s'),
            'php_version' => phpversion()
        ]);
        break;
        
    case 'test.php':
        // Simple test endpoint
        echo json_encode([
            'status' => 'success',
            'message' => 'PHP server is working from root directory!',
            'php_version' => phpversion(),
            'server_time' => date('Y-m-d H:i:s'),
            'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
            'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'Unknown'
        ]);
        break;
        
    case 'basic-test.php':
        // Basic test with plain text
        header('Content-Type: text/plain');
        echo "Railway PHP server is working!\n";
        echo "PHP Version: " . phpversion() . "\n";
        echo "Server Time: " . date('Y-m-d H:i:s') . "\n";
        echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "\n";
        break;
        
    case 'simple-test.php':
        // JSON test endpoint
        echo json_encode([
            'status' => 'success',
            'message' => 'Railway PHP server is working!',
            'php_version' => phpversion(),
            'server_time' => date('Y-m-d H:i:s'),
            'request_method' => $_SERVER['REQUEST_METHOD'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
        ]);
        break;
        
    case 'force-cors.php':
        // Force CORS test
        echo json_encode([
            'status' => 'success',
            'message' => 'CORS headers forced successfully!',
            'php_version' => phpversion(),
            'server_time' => date('Y-m-d H:i:s'),
            'request_method' => $_SERVER['REQUEST_METHOD'],
            'headers_sent' => headers_sent(),
            'cors_origin' => $_SERVER['HTTP_ORIGIN'] ?? 'No Origin header'
        ]);
        break;
        
    case 'api/health.php':
        // Health check endpoint
        try {
            require_once 'src/db.php';
            
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
        break;
        
    default:
        // For other requests, try to serve from public directory
        $public_file = 'public/' . $path;
        if (file_exists($public_file) && is_file($public_file)) {
            // Set appropriate content type
            $ext = pathinfo($public_file, PATHINFO_EXTENSION);
            switch ($ext) {
                case 'php':
                    include $public_file;
                    break;
                case 'html':
                    header('Content-Type: text/html');
                    readfile($public_file);
                    break;
                case 'css':
                    header('Content-Type: text/css');
                    readfile($public_file);
                    break;
                case 'js':
                    header('Content-Type: application/javascript');
                    readfile($public_file);
                    break;
                default:
                    readfile($public_file);
            }
        } else {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'Not found',
                'path' => $path,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
        break;
}
?>
