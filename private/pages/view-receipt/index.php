<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the website instance
    global $website;
    $database = new Database;
    $accountTools = new AccountTools;

    // Validate the ID
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        giveApiError('Invalid ID');
        exit;
    }

    // Get the ID
    $id = (int) $_GET['id'];

    // Fetch the record with the given ID
    $stmt = $database->exe("SELECT * FROM `records` WHERE id = ?", [$id]);

    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row) {
            // Check if the user is aloud to see this receipt
            $user = $website->getUser();
            if($user['id'] != $row['user']){

            }
            
            // Get the receipts
            $receipts = json_decode($row['receipts'], true);

            // Display the receipts
            if (is_array($receipts) && count($receipts) > 0) {
                foreach ($receipts as $receipt) {
                    $filePath = $receipt;
                    if (file_exists($filePath)) {
                        $imageData = base64_encode(file_get_contents($filePath));
                        $mimeType = mime_content_type($filePath);
                        echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Receipt Image">';
                    } else {
                        echo 'Receipt file not found: ' . htmlspecialchars($receipt);
                    }
                }
            } else {
                echo 'No receipts available';
            }
        } else {
            giveApiError('Record not found');
        }
    } else {
        giveApiError('Database query error');
    }
}

// Function to handle API errors
function giveApiError($message) {
    global $website;
    $website->giveApiError($message);
}
?>
