<?php
    // Check if the cookie is set
    if(isset($_COOKIE['session'])) {
        $session = $_COOKIE['session'];

        // Pull the data from the database
        require(dirname(__FILE__).'/../../private/database.php');

        // Check the session is valid
        $stmt = executePreparedStatement("SELECT * FROM `users` WHERE `session` = ?", [$session]);

        if ($stmt) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if(!$row){
                header('location: /login');
                exit();
            }
        }
    } else {
        header('location: /login');
    }