<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $website->giveApiError('Must be post');
}

// Get the website instance
global $website;
$database = new Database;
$accountTools = new AccountTools;

// Get the raw POST data
$rawData = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($rawData, true); 

// Check if ID is provided
if (!isset($data['id']) || !is_numeric($data['id'])) {
    $website->giveApiError('Invalid ID');
    exit;
}

// Get the ID
$id = (int) $data['id'];

// Query to fetch the record with the given ID
$stmt = $database->exe("SELECT * FROM `records` WHERE id = ?", [$id]);

// Check there is a result
if (!$stmt) {
    $website->giveApiError('Database query error');
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    $website->giveApiError('Request not found');
}

// Check if the user is allowed to change the status
$user = $website->getUser();
$recordUser = $website->getUser($row['user']);

if ($user['id'] != $recordUser['manager']) {
    $website->giveApiError('Permission denied');
    exit;
}

// Update the status to 1
$updateStmt = $database->exe("UPDATE `records` SET `status` = -1 WHERE id = ?", [$id]);

// Send the email
$mail = new Mail;
$mail->sendMail($recordUser['email'], 'Form Refused', file_get_contents(dirname(__FILE__)."/../../../../../email-htmls/formDenied.html"));

if ($updateStmt) {
    $website->giveApiResponse([
        'status' => 'ok',
        'message' => 'Status updated successfully'
    ]);
}

$website->giveApiError('Failed to update status');
?>