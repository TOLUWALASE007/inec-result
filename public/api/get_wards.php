<?php
header('Content-Type: application/json');
require_once '../../src/functions.php';

$lga_id = $_GET['lga_id'] ?? '';

if (empty($lga_id)) {
    echo json_encode([]);
    exit;
}

try {
    $wards = getWardsByLGA($pdo, $lga_id);
    echo json_encode($wards);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
