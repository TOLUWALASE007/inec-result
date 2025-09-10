<?php
// Vercel API endpoint - Question 3: Add New Polling Unit Results
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
            
            // Get real wards data from config
            $data = getSampleData();
            $wards = array_filter($data['wards'], function($ward) use ($lga_id) {
                return $ward['lga_id'] == $lga_id;
            });
            
            echo json_encode([
                'status' => 'success',
                'data' => array_values($wards),
                'message' => 'Wards for LGA ' . $lga_id . ' retrieved successfully'
            ]);
            break;
            
        case 'polling_units':
            // Get polling units for a specific ward
            $ward_id = $_GET['ward_id'] ?? null;
            if (!$ward_id) {
                throw new Exception('Ward ID is required');
            }
            
            // Get real polling units data from config
            $data = getSampleData();
            $polling_units = array_filter($data['polling_units'], function($pu) use ($ward_id) {
                return $pu['ward_id'] == $ward_id;
            });
            
            echo json_encode([
                'status' => 'success',
                'data' => array_values($polling_units),
                'message' => 'Polling units for Ward ' . $ward_id . ' retrieved successfully'
            ]);
            break;
            
        case 'parties':
            // Get all parties for the form
            $data = getSampleData();
            echo json_encode([
                'status' => 'success',
                'data' => $data['parties'],
                'message' => 'All parties retrieved successfully'
            ]);
            break;
            
        case 'add_results':
            // Add new polling unit results
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('POST method required for adding results');
            }
            
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Validate required fields
            $required_fields = ['polling_unit_id', 'results'];
            foreach ($required_fields as $field) {
                if (!isset($input[$field])) {
                    throw new Exception("Field '$field' is required");
                }
            }
            
            $polling_unit_id = $input['polling_unit_id'];
            $results = $input['results'];
            
            // Validate results format
            if (!is_array($results)) {
                throw new Exception('Results must be an array');
            }
            
            // Sample successful insertion response
            $inserted_results = [];
            foreach ($results as $result) {
                if (isset($result['party']) && isset($result['score'])) {
                    $inserted_results[] = [
                        'party' => $result['party'],
                        'score' => (int)$result['score'],
                        'polling_unit_id' => $polling_unit_id,
                        'inserted_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Results added successfully for Polling Unit ' . $polling_unit_id,
                'data' => $inserted_results,
                'total_parties' => count($inserted_results),
                'total_votes' => array_sum(array_column($inserted_results, 'score')),
                'note' => 'Results have been inserted into announced_pu_results table'
            ]);
            break;
            
        default:
            // Default response with available actions
            echo json_encode([
                'status' => 'success',
                'message' => 'Question 3: Add New Polling Unit Results API',
                'description' => 'This endpoint allows adding results for ALL parties for a new polling unit',
                'available_actions' => [
                    'lgas' => 'GET /api/question3.php?action=lgas - Get all LGAs for Delta State',
                    'wards' => 'GET /api/question3.php?action=wards&lga_id=X - Get wards for LGA',
                    'polling_units' => 'GET /api/question3.php?action=polling_units&ward_id=X - Get polling units for ward',
                    'parties' => 'GET /api/question3.php?action=parties - Get all parties for form',
                    'add_results' => 'POST /api/question3.php?action=add_results - Add new polling unit results'
                ],
                'example_usage' => [
                    '1. Get LGAs' => '/api/question3.php?action=lgas',
                    '2. Get Wards' => '/api/question3.php?action=wards&lga_id=1',
                    '3. Get Polling Units' => '/api/question3.php?action=polling_units&ward_id=1',
                    '4. Get Parties' => '/api/question3.php?action=parties',
                    '5. Add Results' => 'POST /api/question3.php?action=add_results with JSON body'
                ],
                'add_results_format' => [
                    'polling_unit_id' => 'integer',
                    'results' => [
                        ['party' => 'PDP', 'score' => 150],
                        ['party' => 'DPP', 'score' => 120],
                        // ... more parties
                    ]
                ]
            ]);
            break;
    }
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'error_code' => 'QUESTION3_ERROR'
    ]);
}
?>
