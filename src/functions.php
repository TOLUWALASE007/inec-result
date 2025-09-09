<?php
// src/functions.php
require_once 'db.php';

/**
 * Get all LGAs for Delta State (state_id = 25)
 */
function getLGAs($pdo) {
    $stmt = $pdo->prepare("SELECT uniqueid, lga_id, lga_name FROM lga WHERE state_id = 25 ORDER BY lga_name");
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Get wards for a specific LGA
 */
function getWardsByLGA($pdo, $lga_id) {
    $stmt = $pdo->prepare("
        SELECT DISTINCT w.uniqueid, w.ward_id, w.ward_name 
        FROM ward w 
        INNER JOIN polling_unit pu ON w.uniqueid = pu.ward_id 
        WHERE pu.lga_id = ? 
        ORDER BY w.ward_name
    ");
    $stmt->execute([$lga_id]);
    return $stmt->fetchAll();
}

/**
 * Get polling units for a specific ward
 */
function getPollingUnitsByWard($pdo, $ward_id) {
    $stmt = $pdo->prepare("
        SELECT uniqueid, polling_unit_id, polling_unit_name, polling_unit_number 
        FROM polling_unit 
        WHERE ward_id = ? 
        ORDER BY polling_unit_name
    ");
    $stmt->execute([$ward_id]);
    return $stmt->fetchAll();
}

/**
 * Get polling unit results by uniqueid
 */
function getPollingUnitResults($pdo, $polling_unit_uniqueid) {
    $stmt = $pdo->prepare("
        SELECT party_abbreviation, party_score, entered_by_user, date_entered 
        FROM announced_pu_results 
        WHERE polling_unit_uniqueid = ? 
        ORDER BY party_score DESC
    ");
    $stmt->execute([$polling_unit_uniqueid]);
    return $stmt->fetchAll();
}

/**
 * Get polling unit details by uniqueid
 */
function getPollingUnitDetails($pdo, $polling_unit_uniqueid) {
    $stmt = $pdo->prepare("
        SELECT pu.uniqueid, pu.polling_unit_name, pu.polling_unit_number, pu.polling_unit_description,
               w.ward_name, l.lga_name
        FROM polling_unit pu
        INNER JOIN ward w ON pu.ward_id = w.uniqueid
        INNER JOIN lga l ON pu.lga_id = l.uniqueid
        WHERE pu.uniqueid = ?
    ");
    $stmt->execute([$polling_unit_uniqueid]);
    return $stmt->fetch();
}

/**
 * Get LGA total results by summing all polling units in the LGA
 */
function getLGATotalResults($pdo, $lga_id) {
    $stmt = $pdo->prepare("
        SELECT 
            party_abbreviation,
            SUM(party_score) as total_score
        FROM announced_pu_results apr
        INNER JOIN polling_unit pu ON apr.polling_unit_uniqueid = CAST(pu.uniqueid AS CHAR)
        WHERE pu.lga_id = ?
        GROUP BY party_abbreviation
        ORDER BY total_score DESC
    ");
    $stmt->execute([$lga_id]);
    return $stmt->fetchAll();
}

/**
 * Get LGA details by uniqueid
 */
function getLGADetails($pdo, $lga_id) {
    $stmt = $pdo->prepare("
        SELECT uniqueid, lga_id, lga_name, lga_description 
        FROM lga 
        WHERE uniqueid = ?
    ");
    $stmt->execute([$lga_id]);
    return $stmt->fetch();
}

/**
 * Insert new polling unit results
 */
function insertPollingUnitResults($pdo, $polling_unit_uniqueid, $results, $entered_by_user = 'admin') {
    $pdo->beginTransaction();
    
    try {
        // First, delete existing results for this polling unit
        $deleteStmt = $pdo->prepare("DELETE FROM announced_pu_results WHERE polling_unit_uniqueid = ?");
        $deleteStmt->execute([$polling_unit_uniqueid]);
        
        // Insert new results
        $insertStmt = $pdo->prepare("
            INSERT INTO announced_pu_results 
            (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address) 
            VALUES (?, ?, ?, ?, NOW(), ?)
        ");
        
        $user_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        
        foreach ($results as $party => $score) {
            if (!empty($party) && is_numeric($score)) {
                $insertStmt->execute([$polling_unit_uniqueid, $party, $score, $entered_by_user, $user_ip]);
            }
        }
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

/**
 * Get all parties from existing results (for form dropdown)
 */
function getAllParties($pdo) {
    $stmt = $pdo->prepare("
        SELECT DISTINCT party_abbreviation 
        FROM announced_pu_results 
        ORDER BY party_abbreviation
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
