<?php
global $website;
$user = $website->getUser();
if(!$user['admin']){
    $website->give_404();
    exit();
}
// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize required objects
    $database = new Database; // Assuming Database class handles database operations
    $website = new Website; // Assuming Website class has API response methods

    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    
    // Decode the JSON data
    $data = json_decode($rawData, true); 

    // Mapping of POST data keys to database column names
    $fieldMappings = [
        'admin' => 'admin',
        'email' => 'email',
        'fName' => 'first_name',
        'lName' => 'last_name',
        'manager' => 'manager'
    ];

    // Extract data from POST and map to database column names
    $updateData = [];
    $updateValues = [];
    foreach ($fieldMappings as $postKey => $dbColumn) {
        if (isset($data[$postKey])) {
            $updateData[] = "`$dbColumn` = ?";
            $updateValues[] = $data[$postKey];
        }
    }

    // Validate if any fields were provided for update
    if (empty($updateData)) {
        giveApiError('No valid fields provided for update');
    }

    // Prepare and execute update query
    $setClause = implode(', ', $updateData);
    $query = "UPDATE `users` SET $setClause WHERE `id` = ?";

    // Build params
    $bindParams = array_merge($updateValues, [$data['id']]);
    $paramTypes = str_repeat('s', count($bindParams));

    $stmt = $database->exe($query, $bindParams);

    $website->giveApiResponse(['status' => 'ok']);

    // Close statement
    $stmt->close();
} else {
    // Handle invalid request method
    $website->giveApiError('Invalid request method');
}