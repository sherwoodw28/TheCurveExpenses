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

    // Check that the password meets the standards
    $password = $data['password'];

    if (!$accountTools->validatePassword($password)) {
        $website->giveApiError('The password must contain 8 characters, 1 capital, 1 lowercase, and 1 number');
    }

    // Get the full name
    $full_name = $data['name'];

    // Check the email is not in use
    $stmt = $database->exe("SELECT * FROM `users` WHERE email = ?", [$email]);

    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row){
            $website->giveApiError('Email already in use');
        }
    }

    // Split the name into 2
    list($first_name, $last_name) = explode(" ", $full_name);

    // Generate some infomation
    $hash = $accountTools->generateRandom(20).'__RESET__TOKEN';
    $session = $accountTools->generateRandom(21).'__DO__NOT__SHAIR__YOUR__SESSION';
    $resetToken = $accountTools->generateRandom(22).'__RESET__TOKEN';
    $verifyToken = $accountTools->generateRandom(23);

    // Upload the data to the database
    $password = $data['password'];

    $stmt = $database->exe("INSERT INTO `users`(`first_name`, `last_name`, `email`, `manager`, `notification`, `password`, `session`, `password_token`, `hash`, `verify_token`) VALUES (?,?,?,?,?,?,?,?,?,?)", [ $first_name, $last_name, $email, 0, 0, $accountTools->encryptPassword($password, $hash), $session, $resetToken, $hash, $verifyToken ]);
    $url = 'https://thecurve.odysseynetw.co.uk/verified?token='.$verifyToken;
    
    $mail->sendMail($email, 'Please confirm your email', str_replace('{{URL}}', $url, (str_replace('{{NAME}}', $first_name, file_get_contents(dirname(__FILE__)."/../../../../../email-htmls/verifyEmail.html")))));
    $website->giveApiResponse([
        'status' => 'ok',
        'cookie' => $session
    ]);
}