<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the website instance
    global $website;
    $database = new Database;
    $accountTools = new AccountTools;

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true); 
    $password = $data['password'];

    // Get information of the user
    $user = $website->getUser();

    //Encrypt the users password
    $encryptedPassword = $accountTools->encryptPassword($password, $user["hash"]);

    // Set manager based on the dropdown menu input
    $stmt = $database->exe("UPDATE `users` SET `password` = ? WHERE `id` = ?", [ $encryptedPassword, $user['id'] ]);
    if (!$stmt) {
        $website->giveApiError('An error has occurred. Unable to set password.');
    }

    //Give OK response
    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}