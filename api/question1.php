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

require_once 'config.php';

try {
    $action = $_GET['action'] ?? 'list';
    
    switch ($action) {
        case 'lgas':
            // Get all LGAs for Delta State (state_id = 25)
            $data = getSampleData();
            echo json_encode([
                'status' => 'success',
                'data' => $data['lgas'],
                'message' => 'LGAs for Delta State retrieved successfully'
            ]);
            break;
            
        case 'wards':
            // Get wards for a specific LGA
            $lga_id = $_GET['lga_id'] ?? null;
            if (!$lga_id) {
                throw new Exception('LGA ID is required');
            }
            
            // Sample wards data (you would get this from database)
            $sample_wards = [
                ['id' => 1, 'name' => 'Ward 1', 'lga_id' => $lga_id],
                ['id' => 2, 'name' => 'Ward 2', 'lga_id' => $lga_id],
                ['id' => 3, 'name' => 'Ward 3', 'lga_id' => $lga_id],
                ['id' => 4, 'name' => 'Ward 4', 'lga_id' => $lga_id],
                ['id' => 5, 'name' => 'Ward 5', 'lga_id' => $lga_id]
            ];
            
            echo json_encode([
                'status' => 'success',
                'data' => $sample_wards,
                'message' => 'Wards for LGA ' . $lga_id . ' retrieved successfully'
            ]);
            break;
            
        case 'polling_units':
            // Get polling units for a specific ward
            $ward_id = $_GET['ward_id'] ?? null;
            if (!$ward_id) {
                throw new Exception('Ward ID is required');
            }
            
            // Sample polling units data
            $sample_polling_units = [
                ['id' => 1, 'name' => 'Polling Unit 1', 'ward_id' => $ward_id, 'uniqueid' => 'PU001'],
                ['id' => 2, 'name' => 'Polling Unit 2', 'ward_id' => $ward_id, 'uniqueid' => 'PU002'],
                ['id' => 3, 'name' => 'Polling Unit 3', 'ward_id' => $ward_id, 'uniqueid' => 'PU003']
            ];
            
            echo json_encode([
                'status' => 'success',
                'data' => $sample_polling_units,
                'message' => 'Polling units for Ward ' . $ward_id . ' retrieved successfully'
            ]);
            break;
            
        case 'results':
            // Get results for a specific polling unit
            $polling_unit_id = $_GET['polling_unit_id'] ?? null;
            if (!$polling_unit_id) {
                throw new Exception('Polling Unit ID is required');
            }
            
            // Sample results data
            $data = getSampleData();
            $sample_results = [
                ['party' => 'PDP', 'score' => 150, 'polling_unit_id' => $polling_unit_id],
                ['party' => 'DPP', 'score' => 120, 'polling_unit_id' => $polling_unit_id],
                ['party' => 'ACN', 'score' => 90, 'polling_unit_id' => $polling_unit_id],
                ['party' => 'PPA', 'score' => 60, 'polling_unit_id' => $polling_unit_id],
                ['party' => 'CDC', 'score' => 30, 'polling_unit_id' => $polling_unit_id],
                ['party' => 'JP', 'score' => 25, 'polling_unit_id' => $polling_unit_id],
                ['party' => 'ANPP', 'score' => 20, 'polling_unit_id' => $polling_unit_id],
                ['party' => 'LABO', 'score' => 15, 'polling_unit_id' => $polling_unit_id],
                ['party' => 'CPP', 'score' => 10, 'polling_unit_id' => $polling_unit_id]
            ];
            
            echo json_encode([
                'status' => 'success',
                'data' => $sample_results,
                'message' => 'Results for Polling Unit ' . $polling_unit_id . ' retrieved successfully',
                'total_votes' => array_sum(array_column($sample_results, 'score'))
            ]);
            break;
            
        default:
            // Default response with available actions
            echo json_encode([
                'status' => 'success',
                'message' => 'Question 1: Individual Polling Unit Results API',
                'description' => 'This endpoint handles individual polling unit results with chained selects',
                'available_actions' => [
                    'lgas' => 'GET /api/question1.php?action=lgas - Get all LGAs for Delta State',
                    'wards' => 'GET /api/question1.php?action=wards&lga_id=X - Get wards for LGA',
                    'polling_units' => 'GET /api/question1.php?action=polling_units&ward_id=X - Get polling units for ward',
                    'results' => 'GET /api/question1.php?action=results&polling_unit_id=X - Get results for polling unit'
                ],
                'example_usage' => [
                    '1. Get LGAs' => '/api/question1.php?action=lgas',
                    '2. Get Wards' => '/api/question1.php?action=wards&lga_id=1',
                    '3. Get Polling Units' => '/api/question1.php?action=polling_units&ward_id=1',
                    '4. Get Results' => '/api/question1.php?action=results&polling_unit_id=1'
                ]
            ]);
            break;
    }
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'error_code' => 'QUESTION1_ERROR'
    ]);
}
?>
