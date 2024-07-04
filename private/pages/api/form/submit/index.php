<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $website;
    $database = new Database;

    $accountTools = new AccountTools;

    // Validate and process the received data
    $reason = $_POST['reason'];
    $details = $_POST['details'];
    $dateNeededFrom = new DateTime($_POST['dateNeededFrom']); $dateNeededFrom = $dateNeededFrom->format('Y-m-d H:i:s');
    $dateNeededTo = new DateTime($_POST['dateNeededTo']); $dateNeededTo = $dateNeededTo->format('Y-m-d H:i:s');
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

    // Get the user
    $user = $website->getUser();

    // Insert the data into the records table
    $stmt = $database->exe("INSERT INTO `records`(`date`, `dateAfter`, `status`, `expenses`, `receipts`, `assistance`, `comment`, `user`, `reason`, `details`) VALUES (?,?,?,?,?,?,?,?,?,?)", [
        $dateNeededFrom, // date from
        $dateNeededTo, // date to
        0, // status
        $totalCost, // expenses
        $receiptsJson, // receipts
        $assistance, // assistance
        $comments, // comment
        $user['id'],
        $reason,
        $details
    ]);

    if (!$stmt) {
        $website->giveApiError('Error inserting record into database.');
    }

    $managerID = $user['manager'];

    $managers = $website->getAllUsers();

    foreach ($managers as $tempManager) {
        if($tempManager['id'] == $managerID){
            $manager = $tempManager;
        }
    }

    // Send the email
    $mail = new Mail;
    $mail->sendMail($manager['email'], 'New request submitted', str_replace('{{MANAGER}}', $manager['first_name'], (str_replace('{{NAME}}', $user['first_name'], file_get_contents(dirname(__FILE__)."/../../../../../email-htmls/approvalRequest.html")))));

    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}
