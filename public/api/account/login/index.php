<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the raw POST data
        $rawData = file_get_contents('php://input');
        
        // Decode the JSON data
        $data = json_decode($rawData, true); 

        // Get the username
        $username = $data['username'];

        // Get the password
        $username = $data['password'];

        // Pull the data from the database
        reu
    }