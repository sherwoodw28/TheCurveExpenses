<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $website;
    $database = new Database;

    $accountTools = new AccountTools;

    // Validate and process the received data
    $reason = $_POST['reason'];
    $details = $_POST['details'];
    $dateNeededFrom = $_POST['dateNeededFrom'];
    $dateNeededTo = $_POST['dateNeededTo'];
    $totalCost = $_POST['totalCost'];
    $assistance = intval($_POST['assistance']);
    $comments = $_POST['comments'];

    // Handle file uploads
    $uploadDir = dirname(__DIR__).'/submit/images/';
    $receipts = [];
    for ($i = 1; $i <= 3; $i++) {
        $fileKey = $accountTools->generateRandom(100) . $i;
        if (isset($_FILES['file'.$i]) && $_FILES['file'.$i]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file'.$i]['tmp_name'];
            $fileName = $_FILES['file'.$i]['name'];
            
            // Get the file extension
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Check it's a safe file
            if(!in_array($fileExtension, [ 'png', 'jpg', 'webp', 'pdf', 'jpeg', 'bmp', 'tiff', 'raw', 'hief', 'ico' ])){
                $website->giveApiError('File format not supported');
            }
            
            // Create the destination path with the file key and extension
            $destPath = $uploadDir . $fileKey . '.' . $fileExtension;
            
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $receipts[] = $destPath;
            } else {
                $website->giveApiError('Error moving uploaded file.');
            }
        }
    }    

    // Convert receipts array to JSON
    $receiptsJson = json_encode($receipts);

    // Insert the data into the records table
    $stmt = $database->exe("INSERT INTO `records`(`date`, `status`, `expenses`, `receipts`, `assistance`, `comment`) VALUES (?,?,?,?,?,?)", [
        date('Y-m-d H:i:s'), // date
        0, // status
        $totalCost, // expenses
        $receiptsJson, // receipts
        $assistance, // assistance
        $comments // comment
    ]);

    if ($stmt) {
        $website->giveApiResponse([
            'status' => 'ok'
        ]);
    } else {
        $website->giveApiError('Error inserting record into database.');
    }
}
