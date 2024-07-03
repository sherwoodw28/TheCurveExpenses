<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the website instance
    global $website;
    $database = new Database;
    $accountTools = new AccountTools;

    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    // Decode the JSON data
    $data = json_decode($rawData, true); 
    // Get the id of the selected manager
    $managerID = $data['manager'];

    // Ensure the manager is valid
    $stmt = $database->exe("SELECT * FROM `users` WHERE `id` = ?", [$managerID]);
    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(!$row){
            $website->giveApiError('Invalid manager');
        }
    }

    // Get information of the user
    $user = $website->getUser();

    // Set manager based on the dropdown menu input
    $stmt = $database->exe("UPDATE `users` SET `manager` = ? WHERE `id` = ?", [ $managerID, $user['id'] ]);
    if (!$stmt) {
        $website->giveApiError('An error has occurred. Unable to set manager');
    }

    //Give OK response
    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}