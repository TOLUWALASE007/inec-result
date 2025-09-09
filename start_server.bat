@echo off
echo Starting INEC Results Portal...
echo.
echo Make sure you have:
echo 1. MySQL running with database 'bincomphptest' imported
echo 2. PHP installed with PDO MySQL extension
echo.
echo Starting PHP development server...
echo Access the application at: http://localhost:8000/public/show_polling_unit.php
echo.
echo Press Ctrl+C to stop the server
echo.
php -S localhost:8000 -t .
