<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header("Content-Type: application/json; charset=UTF-8");

        // Get the raw POST data
        $rawData = file_get_contents('php://input');
        
        // Decode the JSON data
        $data = json_decode($rawData, true); 

        // Get the email
        $email = $data['email'];

        // Get the password
        $password = $data['password'];

        // Pull the data from the database
        require(dirname(__FILE__).'/../../../../private/database.php');

        // Get the hash
        $stmt = executePreparedStatement("SELECT * FROM `users` WHERE email = ?", $email);


        if ($stmt) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if($row){
                echo($row['hash']);
            } else{
                echo json_encode([
                    'error' => 'Invalid username/password/'
                ]);
            }
        }
    }