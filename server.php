<?php
// Railway-compatible PHP server script
// This script starts the PHP built-in server with proper host and port binding

// Get the PORT environment variable from Railway
$port = $_ENV['PORT'] ?? 8000;

// Start the PHP built-in server
// Bind to 0.0.0.0 (all interfaces) and use Railway's PORT
$command = "php -S 0.0.0.0:$port";
echo "Starting PHP server: $command\n";
echo "Server will be available at: http://0.0.0.0:$port\n";

// Execute the command
passthru($command);
?>