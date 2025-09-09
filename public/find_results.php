<?php
require_once __DIR__ . '/../src/db.php';

// Get LGAs with results
$stmt = $pdo->prepare("
    SELECT DISTINCT l.lga_name, l.uniqueid as lga_id, 
           COUNT(DISTINCT pu.uniqueid) as polling_units_with_results
    FROM lga l 
    JOIN ward w ON l.uniqueid = w.lga_id 
    JOIN polling_unit pu ON w.uniqueid = pu.ward_id 
    JOIN announced_pu_results apr ON pu.uniqueid = CAST(apr.polling_unit_uniqueid AS UNSIGNED) 
    WHERE l.state_id = 25 
    GROUP BY l.uniqueid 
    ORDER BY polling_units_with_results DESC
");
$stmt->execute();
$lgas_with_results = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find Polling Units with Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-2xl p-6">
        <h1 class="text-2xl font-bold mb-6">Polling Units with Results - Test Helper</h1>
        
        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Quick Test Combinations:</h2>
            <p class="text-sm text-gray-700">Use these exact combinations to see results in the main application:</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($lgas_with_results as $lga): ?>
                <div class="border rounded-lg p-4">
                    <h3 class="font-semibold text-lg mb-2">
                        <?= htmlspecialchars($lga['lga_name']) ?>
                        <span class="text-sm text-gray-600">(<?= $lga['polling_units_with_results'] ?> polling units)</span>
                    </h3>
                    
                    <?php
                    // Get wards for this LGA with results
                    $stmt = $pdo->prepare("
                        SELECT DISTINCT w.ward_name, w.uniqueid as ward_id,
                               COUNT(DISTINCT pu.uniqueid) as polling_units_count
                        FROM ward w 
                        JOIN polling_unit pu ON w.uniqueid = pu.ward_id 
                        JOIN announced_pu_results apr ON pu.uniqueid = CAST(apr.polling_unit_uniqueid AS UNSIGNED) 
                        WHERE w.lga_id = ?
                        GROUP BY w.uniqueid 
                        ORDER BY polling_units_count DESC
                        LIMIT 3
                    ");
                    $stmt->execute([$lga['lga_id']]);
                    $wards = $stmt->fetchAll();
                    ?>
                    
                    <div class="space-y-2">
                        <?php foreach ($wards as $ward): ?>
                            <div class="bg-gray-50 p-2 rounded">
                                <strong><?= htmlspecialchars($ward['ward_name']) ?></strong>
                                <span class="text-sm text-gray-600">(<?= $ward['polling_units_count'] ?> units)</span>
                                
                                <?php
                                // Get specific polling units for this ward
                                $stmt = $pdo->prepare("
                                    SELECT pu.uniqueid, pu.polling_unit_name,
                                           COUNT(apr.party_abbreviation) as party_count
                                    FROM polling_unit pu 
                                    JOIN announced_pu_results apr ON pu.uniqueid = CAST(apr.polling_unit_uniqueid AS UNSIGNED) 
                                    WHERE pu.ward_id = ?
                                    GROUP BY pu.uniqueid 
                                    ORDER BY party_count DESC
                                    LIMIT 2
                                ");
                                $stmt->execute([$ward['ward_id']]);
                                $polling_units = $stmt->fetchAll();
                                ?>
                                
                                <div class="ml-4 mt-1 space-y-1">
                                    <?php foreach ($polling_units as $pu): ?>
                                        <div class="text-sm">
                                            <a href="show_polling_unit.php?pu_id=<?= $pu['uniqueid'] ?>" 
                                               class="text-blue-600 hover:underline">
                                                <?= htmlspecialchars($pu['polling_unit_name']) ?>
                                            </a>
                                            <span class="text-gray-500">(<?= $pu['party_count'] ?> parties)</span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-8 p-4 bg-green-50 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">How to Use:</h2>
            <ol class="list-decimal list-inside space-y-1 text-sm">
                <li>Click any polling unit link above to go directly to results</li>
                <li>Or use the main form: <a href="show_polling_unit.php" class="text-blue-600 hover:underline">Go to Polling Unit Results</a></li>
                <li>Select the LGA → Ward → Polling Unit combinations shown above</li>
            </ol>
        </div>
    </div>
</body>
</html>
