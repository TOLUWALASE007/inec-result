<?php
$page_title = 'INEC Results Portal - Home';
include '../templates/header.php';
?>

<div class="px-4 py-6 sm:px-0">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">INEC Results Portal</h1>
        <p class="text-xl text-gray-600">Delta State Election Results Database</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Question 1: Individual Polling Unit Results -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Individual Polling Unit Results</h3>
                <p class="text-gray-600 mb-4">View detailed results for any specific polling unit in Delta State.</p>
                <a href="show_polling_unit.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-inec-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View Results
                </a>
            </div>
        </div>

        <!-- Question 2: LGA Total Results -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">LGA Total Results</h3>
                <p class="text-gray-600 mb-4">View summed totals of all polling units within a Local Government Area.</p>
                <a href="show_lga_sum.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-inec-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    View LGA Totals
                </a>
            </div>
        </div>

        <!-- Question 3: Add New Polling Unit Results -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Add New Results</h3>
                <p class="text-gray-600 mb-4">Store results for all parties for a new polling unit.</p>
                <a href="add_polling_unit.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Add Results
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="mt-12 bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Database Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-inec-blue">25</div>
                <div class="text-sm text-gray-600">Local Government Areas</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-inec-green">270+</div>
                <div class="text-sm text-gray-600">Wards</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600">8,000+</div>
                <div class="text-sm text-gray-600">Polling Units</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-orange-600">9</div>
                <div class="text-sm text-gray-600">Political Parties</div>
            </div>
        </div>
    </div>

    <!-- Instructions Section -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-blue-900 mb-3">How to Use This Portal</h3>
        <ul class="list-disc list-inside text-blue-800 space-y-2">
            <li><strong>Individual Results:</strong> Select a polling unit to view detailed party results</li>
            <li><strong>LGA Totals:</strong> Choose an LGA to see aggregated results across all polling units</li>
            <li><strong>Add Results:</strong> Store new polling unit results for all participating parties</li>
        </ul>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
