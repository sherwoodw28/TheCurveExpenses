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
function executePreparedStatement($sql, $params) {
    global $conn;

    // Ensure $conn is a valid mysqli instance
    if (!$conn instanceof mysqli) {
        error_log("Database connection is not a valid mysqli instance.");
        return false;
    }

    try {
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            error_log("Failed to prepare the statement: " . $conn->error);
            return false;
        }

        // Bind parameters
        if ($params) {
            // Create a string with the types of the parameters
            $types = str_repeat('s', count($params)); // assuming all parameters are strings for simplicity
            $stmt->bind_param($types, ...$params);
        }

        // Execute the statement
        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Failed to execute the statement: " . $stmt->error);
            return false;
        }
    } catch (mysqli_sql_exception $e) {
        // Log detailed error message
        error_log("Error executing prepared statement: " . $e->getMessage());
        return false;
    }
}
