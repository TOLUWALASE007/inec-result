<?php
// Simple PHP server entry point for Railway
// This file starts the PHP built-in server

// Set CORS headers first
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Change to public directory
chdir('public');

// Start the server
$host = '0.0.0.0';
$port = $_ENV['PORT'] ?? 8000;

echo "Starting PHP server on $host:$port\n";
echo "Document root: " . getcwd() . "\n";

// Start the built-in server
passthru("php -S $host:$port");
?>
