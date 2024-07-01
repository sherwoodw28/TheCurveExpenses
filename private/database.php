<?php
$username = 'access';
$password = 'password';
$database = 'main';
$host = '192.168.10.110:3306';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection success
function executePreparedStatement($sql, $param) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Handle errors here, e.g., log the error
        echo "Error preparing statement: " . $conn->error;
        return false;
    }

    // Bind parameters (s stands for string, adjust if needed)
    $stmt->bind_param('s', $param);

    if (!$stmt->execute()) {
        // Handle execution errors
        echo "Error executing statement: " . $stmt->error;
        return false;
    }

    return $stmt;
}