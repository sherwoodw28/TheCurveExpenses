<?php
global $website;
$user = $website->getUser();
if(!$user['admin']){
    $website->give_404();
    exit();
}
// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize required objects
    $database = new Database; // Assuming Database class handles database operations
    $website = new Website; // Assuming Website class has API response methods

    // Get the raw POST data
    $rawData = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($rawData, true); 

    $stmt = $database->exe("DELETE FROM `records` WHERE `id` = ?", [ $data['id'] ]);
    if (!$stmt) {
        $website->giveApiError('An error has occurred. Unable to delete user');
    }
    //Give OK response
    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}