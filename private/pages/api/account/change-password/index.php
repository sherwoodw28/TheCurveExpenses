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

    // Validate the password
    if(!$accountTools->validatePassword($password)){
        $website->giveApiError('The password must contain 8 characters, 1 capital, 1 lowercase, and 1 number');
    }

    // Generate the new infomation
    $hash = $accountTools->generateRandom(20);
    $session = $accountTools->generateRandom(21).'__DO__NOT__SHAIR__YOUR__SESSION';
    $resetToken = $accountTools->generateRandom(22).'__RESET__TOKEN';

    //Encrypt the users password
    $encryptedPassword = $accountTools->encryptPassword($password, $hash);

    // Set manager based on the dropdown menu input
    $stmt = $database->exe("UPDATE `users` SET `password` = ?, `hash` = ?, `session` = ?, `password_token` = ? WHERE `id` = ?", [ $encryptedPassword, $hash, $session, $resetToken, $user['id'] ]);
    if (!$stmt) {
        $website->giveApiError('An error has occurred. Unable to set password.');
    }

    //Give OK response
    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}