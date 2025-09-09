<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'INEC Results Portal'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'inec-green': '#00A651',
                        'inec-blue': '#0066CC'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-inec-green text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="text-xl font-bold">INEC Results Portal</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="index.php" class="hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="show_polling_unit.php" class="hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">Polling Unit Results</a>
                    <a href="show_lga_sum.php" class="hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">LGA Totals</a>
                    <a href="add_polling_unit.php" class="hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">Add Results</a>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
