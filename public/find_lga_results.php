<?php
require_once __DIR__ . '/../src/db.php';

// Get all LGAs with their result counts
$stmt = $pdo->prepare("
    SELECT l.uniqueid, l.lga_name, 
           COUNT(DISTINCT pu.uniqueid) as polling_units_with_results,
           COUNT(apr.party_abbreviation) as total_party_records,
           SUM(apr.party_score) as total_votes
    FROM lga l 
    LEFT JOIN ward w ON l.uniqueid = w.lga_id 
    LEFT JOIN polling_unit pu ON w.uniqueid = pu.ward_id 
    LEFT JOIN announced_pu_results apr ON pu.uniqueid = CAST(apr.polling_unit_uniqueid AS UNSIGNED)
    WHERE l.state_id = 25 
    GROUP BY l.uniqueid 
    HAVING polling_units_with_results > 0
    ORDER BY total_votes DESC
");
$stmt->execute();
$lgas_with_results = $stmt->fetchAll();

// Get sample results for each LGA
$sample_results = [];
foreach ($lgas_with_results as $lga) {
    $stmt = $pdo->prepare("
        SELECT apr.party_abbreviation, SUM(apr.party_score) AS total_score
        FROM announced_pu_results apr
        WHERE apr.polling_unit_uniqueid IN (
            SELECT CONCAT(pu.uniqueid) 
            FROM polling_unit pu 
            WHERE pu.lga_id = ?
        )
        GROUP BY apr.party_abbreviation
        ORDER BY total_score DESC
        LIMIT 5
    ");
    $stmt->execute([$lga['uniqueid']]);
    $sample_results[$lga['uniqueid']] = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LGA Results Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-2xl p-6">
        <h1 class="text-2xl font-bold mb-6">LGA Results Finder - Test Helper</h1>
        
        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Quick Test Guide:</h2>
            <p class="text-sm text-gray-700">Click any LGA link below to see its summed results, or use the main LGA page.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($lgas_with_results as $lga): ?>
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <h3 class="font-semibold text-lg mb-2">
                        <a href="show_lga_sum.php?lga_id=<?= $lga['uniqueid'] ?>" 
                           class="text-blue-600 hover:underline">
                            <?= htmlspecialchars($lga['lga_name']) ?>
                        </a>
                    </h3>
                    
                    <div class="text-sm text-gray-600 mb-3">
                        <p><strong>Polling Units:</strong> <?= $lga['polling_units_with_results'] ?></p>
                        <p><strong>Total Votes:</strong> <?= number_format($lga['total_votes']) ?></p>
                        <p><strong>Party Records:</strong> <?= $lga['total_party_records'] ?></p>
                    </div>

                    <?php if (isset($sample_results[$lga['uniqueid']]) && !empty($sample_results[$lga['uniqueid']])): ?>
                        <div class="mt-3">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Top 5 Parties:</h4>
                            <div class="space-y-1">
                                <?php foreach ($sample_results[$lga['uniqueid']] as $result): ?>
                                    <div class="flex justify-between text-xs">
                                        <span class="font-medium"><?= htmlspecialchars($result['party_abbreviation']) ?></span>
                                        <span class="text-gray-600"><?= number_format($result['total_score']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mt-3 pt-2 border-t">
                        <a href="show_lga_sum.php?lga_id=<?= $lga['uniqueid'] ?>" 
                           class="inline-block bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700">
                            View Full Results
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($lgas_with_results)): ?>
            <div class="text-center py-8">
                <p class="text-gray-600">No LGAs with results found.</p>
            </div>
        <?php endif; ?>

        <div class="mt-8 p-4 bg-green-50 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">How to Use:</h2>
            <ol class="list-decimal list-inside space-y-1 text-sm">
                <li>Click any LGA card above to go directly to its summed results</li>
                <li>Or use the main form: <a href="show_lga_sum.php" class="text-blue-600 hover:underline">Go to LGA Summed Results</a></li>
                <li>Select the LGA from the dropdown to see aggregated party totals</li>
            </ol>
        </div>

        <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Data Summary:</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600"><?= count($lgas_with_results) ?></div>
                    <div class="text-gray-600">LGAs with Results</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600"><?= array_sum(array_column($lgas_with_results, 'polling_units_with_results')) ?></div>
                    <div class="text-gray-600">Total Polling Units</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600"><?= number_format(array_sum(array_column($lgas_with_results, 'total_votes'))) ?></div>
                    <div class="text-gray-600">Total Votes</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600"><?= array_sum(array_column($lgas_with_results, 'total_party_records')) ?></div>
                    <div class="text-gray-600">Party Records</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
