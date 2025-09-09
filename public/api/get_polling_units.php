<?php
header('Content-Type: application/json');
require_once '../../src/functions.php';

$ward_id = $_GET['ward_id'] ?? '';

if (empty($ward_id)) {
    echo json_encode([]);
    exit;
}

try {
    $polling_units = getPollingUnitsByWard($pdo, $ward_id);
    echo json_encode($polling_units);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
