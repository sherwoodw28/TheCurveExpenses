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

    // Get the if of the selected manager
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

    if(!$token = $data['token'] ?: null){
        $website->giveApiError('An error has occurred. Invalid token');
        exit();
    }

    $user = $website->getUser();

    if($user['verify_token'] != $token){
        $website->giveApiError('An error has occurred. Invalid token');
        exit();
    }

    // Verify account
    $stmt = $database->exe("UPDATE `users` SET `verified` = '1' WHERE `id` = ?", [ $user['id'] ]);
    if (!$stmt) {
        $website->giveApiError('An error has occurred. Unable to verify account');
    }

    // Set manager
    $stmt = $database->exe("UPDATE `users` SET `manager` = ? WHERE `id` = ?", [ $managerID, $user['id'] ]);
    if (!$stmt) {
        $website->giveApiError('An error has occurred. Unable to set manager');
    }

    // Ensure they don't verify again
    $stmt = $database->exe("UPDATE `users` SET `verify_token` = ? WHERE `id` = ?", [ '', $user['id'] ]);
    if (!$stmt) {
        $website->giveApiError('An error has occurred. Unable to unset token. Your account has been verified');
    }

    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}