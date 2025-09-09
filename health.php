<?php
// Simple healthcheck endpoint for Railway
header('Content-Type: application/json');
echo json_encode(['status' => 'ok', 'timestamp' => date('Y-m-d H:i:s')]);
?>
