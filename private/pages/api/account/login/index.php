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

    // Get the email
    $email = $data['email'];

    // Check that it is a valid email
    if (!$accountTools->validateEmail($email)){
        $website->giveApiError('Please enter a valid email');
    }

    // Get the hash
    $stmt = $database->exe("SELECT * FROM `users` WHERE email = ?", [$email]);


    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(!$row){
            $website->giveApiError('Invalid username/password');
        }
    }

    // Get the hash
    $hash = $row['hash'];

    // Get the password
    $password = $data['password'];

    // Get the encrypted password
    $encPassword = $accountTools->encryptPassword($password, $hash);

    // Validate the users password
    $stmt = $database->exe("SELECT * FROM `users` WHERE email = ? AND password = ?", [$email, $encPassword]);


    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row){
            $website->giveApiResponse([
                'status' => 'ok',
                'cookie' => $row['session']
            ]);
        } else{
            $website->giveApiError('Invalid username/password');
        }
    }
}