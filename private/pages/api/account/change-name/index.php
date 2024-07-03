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
    $name = $data['name'];

    // Get information of the user
    $user = $website->getUser();

    // Set name based on the input
    $stmt = $database->exe("UPDATE `users` SET `name` = ? WHERE `id` = ?", [ $name, $user['id'] ]);
    if (!$stmt) {
        $website->giveApiError('An error has occurred. Unable to set name');
    }

    //Give OK response
    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}