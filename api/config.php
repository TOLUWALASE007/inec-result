<?php
// Database configuration for Vercel
// Using free MySQL hosting service

// For now, we'll use a simple JSON file approach
// Later you can connect to a real MySQL database

function getDatabaseConfig() {
    // You can replace these with your actual database credentials
    // For free MySQL hosting, try: https://www.freemysqlhosting.net/ or https://www.db4free.net/
    
    return [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'dbname' => $_ENV['DB_NAME'] ?? 'bincomphptest',
        'username' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASS'] ?? '',
        'charset' => 'utf8mb4'
    ];
}

function getPDOConnection() {
    try {
        $config = getDatabaseConfig();
        
        // For Vercel, we'll use a simple file-based approach first
        // This allows the app to work without a database initially
        return null; // Will implement file-based data storage
        
    } catch (Exception $e) {
        error_log("Database connection failed: " . $e->getMessage());
        return null;
    }
}

// Real data from sql/bincom_test.sql file
function getSampleData() {
    return [
        'lgas' => [
            ['id' => 1, 'name' => 'Aniocha North', 'state_id' => 25],
            ['id' => 2, 'name' => 'Aniocha - South', 'state_id' => 25],
            ['id' => 3, 'name' => 'Ethiope East', 'state_id' => 25],
            ['id' => 4, 'name' => 'Ethiope West', 'state_id' => 25],
            ['id' => 5, 'name' => 'Ika North - East', 'state_id' => 25],
            ['id' => 6, 'name' => 'Ika - South', 'state_id' => 25],
            ['id' => 7, 'name' => 'Isoko North', 'state_id' => 25],
            ['id' => 8, 'name' => 'Isoko South', 'state_id' => 25],
            ['id' => 9, 'name' => 'Ndokwa East', 'state_id' => 25],
            ['id' => 10, 'name' => 'Ndokwa West', 'state_id' => 25],
            ['id' => 11, 'name' => 'Okpe', 'state_id' => 25],
            ['id' => 12, 'name' => 'Oshimili - North', 'state_id' => 25],
            ['id' => 13, 'name' => 'Oshimili - South', 'state_id' => 25],
            ['id' => 14, 'name' => 'Patani', 'state_id' => 25],
            ['id' => 15, 'name' => 'Sapele', 'state_id' => 25],
            ['id' => 16, 'name' => 'Udu', 'state_id' => 25],
            ['id' => 17, 'name' => 'Ughelli North', 'state_id' => 25],
            ['id' => 18, 'name' => 'Ughelli South', 'state_id' => 25],
            ['id' => 19, 'name' => 'Ukwuani', 'state_id' => 25],
            ['id' => 20, 'name' => 'Uvwie', 'state_id' => 25],
            ['id' => 21, 'name' => 'Bomadi', 'state_id' => 25],
            ['id' => 22, 'name' => 'Burutu', 'state_id' => 25],
            ['id' => 23, 'name' => 'Warri North', 'state_id' => 25],
            ['id' => 24, 'name' => 'Warri South', 'state_id' => 25],
            ['id' => 25, 'name' => 'Warri South West', 'state_id' => 25]
        ],
        'parties' => [
            ['id' => 1, 'partyname' => 'PDP'],
            ['id' => 2, 'partyname' => 'DPP'],
            ['id' => 3, 'partyname' => 'ACN'],
            ['id' => 4, 'partyname' => 'PPA'],
            ['id' => 5, 'partyname' => 'CDC'],
            ['id' => 6, 'partyname' => 'JP'],
            ['id' => 7, 'partyname' => 'ANPP'],
            ['id' => 8, 'partyname' => 'LABO'],
            ['id' => 9, 'partyname' => 'CPP']
        ],
        'wards' => [
            // Aniocha North (LGA ID 1)
            ['id' => 1, 'name' => 'Ezi', 'lga_id' => 1],
            ['id' => 2, 'name' => 'Idumuje - Unor', 'lga_id' => 1],
            ['id' => 3, 'name' => 'Issele - Azagba', 'lga_id' => 1],
            ['id' => 4, 'name' => 'Issele Uku I', 'lga_id' => 1],
            ['id' => 5, 'name' => 'Issele Uku Ii', 'lga_id' => 1],
            ['id' => 6, 'name' => 'Obior', 'lga_id' => 1],
            ['id' => 7, 'name' => 'Obomkpa', 'lga_id' => 1],
            ['id' => 8, 'name' => 'Onicha - Olona', 'lga_id' => 1],
            ['id' => 9, 'name' => 'Onicha Ugbo', 'lga_id' => 1],
            
            // Aniocha South (LGA ID 2)
            ['id' => 10, 'name' => 'Aba - Unor', 'lga_id' => 2],
            ['id' => 11, 'name' => 'Ejeme', 'lga_id' => 2],
            ['id' => 12, 'name' => 'Isheagu - Ewulu', 'lga_id' => 2],
            ['id' => 13, 'name' => 'Nsukwa', 'lga_id' => 2],
            ['id' => 14, 'name' => 'Ogwashi - Uku I', 'lga_id' => 2],
            ['id' => 15, 'name' => 'Ogwashi - Uku Ii', 'lga_id' => 2],
            ['id' => 16, 'name' => 'Ogwashi - Uku Village', 'lga_id' => 2],
            ['id' => 17, 'name' => 'Ubulu - Uku I', 'lga_id' => 2],
            ['id' => 18, 'name' => 'Ubulu - Uku Ii', 'lga_id' => 2],
            ['id' => 19, 'name' => 'Ubulu - Unor', 'lga_id' => 2],
            ['id' => 20, 'name' => 'Ubulu Okiti', 'lga_id' => 2]
        ],
        'polling_units' => [
            // Sample polling units from the real data
            ['id' => 1, 'name' => 'Sapele Ward 8 PU', 'ward_id' => 1, 'uniqueid' => '8'],
            ['id' => 2, 'name' => 'Primary School in Aghara', 'ward_id' => 2, 'uniqueid' => '9'],
            ['id' => 3, 'name' => 'Ishere Primary School Aghara', 'ward_id' => 3, 'uniqueid' => '10'],
            ['id' => 4, 'name' => 'Igini Primary School', 'ward_id' => 4, 'uniqueid' => '11'],
            ['id' => 5, 'name' => 'Umukwapa poll unit 1', 'ward_id' => 5, 'uniqueid' => '12'],
            ['id' => 6, 'name' => 'Church in Effurun1 Ovie', 'ward_id' => 6, 'uniqueid' => '13'],
            ['id' => 7, 'name' => 'Ishere Primary School Aghara', 'ward_id' => 7, 'uniqueid' => '14'],
            ['id' => 8, 'name' => 'Effurun 2 in Uvwie', 'ward_id' => 8, 'uniqueid' => '15'],
            ['id' => 9, 'name' => 'school in ethiope west', 'ward_id' => 9, 'uniqueid' => '16'],
            ['id' => 10, 'name' => 'agbasa 1', 'ward_id' => 10, 'uniqueid' => '17']
        ],
        'real_results' => [
            // Real results from announced_pu_results table
            ['polling_unit_id' => 1, 'party' => 'PDP', 'score' => 802],
            ['polling_unit_id' => 1, 'party' => 'DPP', 'score' => 719],
            ['polling_unit_id' => 1, 'party' => 'ACN', 'score' => 416],
            ['polling_unit_id' => 1, 'party' => 'PPA', 'score' => 939],
            ['polling_unit_id' => 1, 'party' => 'CDC', 'score' => 394],
            ['polling_unit_id' => 1, 'party' => 'JP', 'score' => 99],
            
            ['polling_unit_id' => 2, 'party' => 'PDP', 'score' => 285],
            ['polling_unit_id' => 2, 'party' => 'DPP', 'score' => 1254],
            ['polling_unit_id' => 2, 'party' => 'ACN', 'score' => 1032],
            ['polling_unit_id' => 2, 'party' => 'PPA', 'score' => 179],
            ['polling_unit_id' => 2, 'party' => 'CDC', 'score' => 752],
            ['polling_unit_id' => 2, 'party' => 'JP', 'score' => 172],
            
            ['polling_unit_id' => 3, 'party' => 'PDP', 'score' => 561],
            ['polling_unit_id' => 3, 'party' => 'DPP', 'score' => 482],
            ['polling_unit_id' => 3, 'party' => 'ACN', 'score' => 298],
            ['polling_unit_id' => 3, 'party' => 'PPA', 'score' => 833],
            ['polling_unit_id' => 3, 'party' => 'CDC', 'score' => 221],
            ['polling_unit_id' => 3, 'party' => 'JP', 'score' => 557],
            
            ['polling_unit_id' => 4, 'party' => 'PDP', 'score' => 621],
            ['polling_unit_id' => 4, 'party' => 'DPP', 'score' => 637],
            ['polling_unit_id' => 4, 'party' => 'ACN', 'score' => 456],
            ['polling_unit_id' => 4, 'party' => 'PPA', 'score' => 789],
            ['polling_unit_id' => 4, 'party' => 'CDC', 'score' => 334],
            ['polling_unit_id' => 4, 'party' => 'JP', 'score' => 445]
        ]
    ];
}
?>
