<?php
// Simple PHP server entry point for Railway
// This file starts the PHP built-in server

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
