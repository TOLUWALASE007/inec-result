<?php
// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

if ($_GET['action'] === 'getWards' && isset($_GET['lga_id'])) {
    $stmt = $pdo->prepare("SELECT uniqueid, ward_name FROM ward WHERE lga_id = ? ORDER BY ward_name");
    $stmt->execute([$_GET['lga_id']]);
    echo json_encode($stmt->fetchAll());
    exit;
}

if ($_GET['action'] === 'getPUs' && isset($_GET['ward_id'])) {
    $stmt = $pdo->prepare("SELECT uniqueid, polling_unit_name FROM polling_unit WHERE ward_id = ? ORDER BY polling_unit_name");
    $stmt->execute([$_GET['ward_id']]);
    echo json_encode($stmt->fetchAll());
    exit;
}
