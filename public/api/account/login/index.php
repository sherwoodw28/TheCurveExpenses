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

    // Pull the data from the database
    require(dirname(__FILE__).'/../../../../private/database.php');

    // Get the hash
    $stmt = executePreparedStatement("SELECT * FROM `users` WHERE email = ?", [$email]);


    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(!$row){
            echo json_encode([
                'status' => 'error',
                'error' => 'Invalid username/password/'
            ]);
            exit();
        }
    }

    // Get the hash
    $hash = $row['hash'];

    // Get the password
    $password = $data['password'];

    // Get the encrypted password
    $encPassword = encryptPassword($password, $hash);

    // Validate the users password
    $stmt = executePreparedStatement("SELECT * FROM `users` WHERE email = ? AND password = ?", [$email, $encPassword]);


    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row){
            echo json_encode([
                'status' => 'ok',
                'cookie' => $row['session']
            ]);
            exit();
        } else{
            echo json_encode([
                'status' => 'error',
                'error' => 'Password is wrong'
            ]);
            exit();
        }
    }
}

function encryptPassword($password, $hash){
    $secret_key = "ydygfuireytdfviute65yf5et".$hash;
    $cipher = "aes-256-cbc";
    $options = 0;
    $iv = "74hf8rh3ng06hdgr";
    return (openssl_encrypt($password, $cipher, $secret_key, $options, $iv));
}