<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: application/json; charset=UTF-8");

    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    
    // Decode the JSON data
    $data = json_decode($rawData, true); 

    // Get the email
    $email = $data['email']; 

    // Check that it is a valid email
    function validateEmail($email) {
        $pattern = '/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,4}$/';
        return preg_match($pattern, $email) === 1;
    }
    
    if (!validateEmail($email)) {
        echo json_encode([
            'status' => 'error',
            'error' => 'Please enter a valid email'
        ]);
        exit();
    }

    // Check that the password meets the standards
    function validatePassword($password) {
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
        return preg_match($pattern, $password) === 1;
    }

    $password = $data['password'];

    if (!validatePassword($password)) {
        echo json_encode([
            'status' => 'error',
            'error' => 'The password must contain: 1 (a-z), 1 (A-Z), and be atleast 8 characters long'
        ]);
        exit();
    }

    // Get the full name
    $full_name = $data['name'];

    // Pull the data from the database
    require(dirname(__FILE__).'/../../../../private/database.php');

    // Check the email is not in use
    $stmt = executePreparedStatement("SELECT * FROM `users` WHERE email = ?", [$email]);

    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row){
            echo json_encode([
                'status' => 'error',
                'error' => 'Email is already in use'
            ]);
            exit();
        }
    }

    // Split the name into 2
    list($first_name, $last_name) = explode(" ", $full_name);

    // Generate some infomation
    $hash = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
    $session = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 21);
    $resetToken = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 22);

    // Upload the data to the database
    $password = $data['password'];

    $stmt = executePreparedStatement("INSERT INTO `users`(`first_name`, `last_name`, `email`, `manager`, `notification`, `password`, `session`, `password_token`, `hash`) VALUES (?,?,?,?,?,?,?,?,?)", [ $first_name, $last_name, $email, 0, 0, encryptPassword($password, $hash), $session, $resetToken, $hash ]);
    echo json_encode([
        'status' => 'ok',
        'cookie' => $session
    ]);
    exit();
}


function encryptPassword($password, $hash){
    $secret_key = "ydygfuireytdfviute65yf5et".$hash;
    $cipher = "aes-256-cbc";
    $options = 0;
    $iv = "74hf8rh3ng06hdgr";
    return (openssl_encrypt($password, $cipher, $secret_key, $options, $iv));
}