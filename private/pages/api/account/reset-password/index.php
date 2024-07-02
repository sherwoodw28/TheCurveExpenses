<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the website instance
    global $website;
    $database = new Database;
    $accountTools = new AccountTools;
    $mail = new Mail;

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

    // Get the email is actually in use
    $stmt = $database->exe("SELECT * FROM `users` WHERE email = ?", [$email]);


    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(!$row){
            $website->giveApiError('Email not currently registered');
        }
    }

    $url = '';

    $mail->sendMail($email, 'Password Reset', str_replace('{{url}}', $url, file_get_contents(dirname(__FILE__)."/../../../../../email-htmls/forgotPassword.html")));
    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}