<?php
    global $website;
    $website->loginRedirect(1);
    
    if(!$token = $_GET['token'] ?: null){
        header('location: /dashboard');
        exit();
    }

    $database = new Database;
    $user = $website->getUser();

    if($user['password_token'] != $token){
        header('location: /dashboard');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - The Curve</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="/assets/confirm_pass/style.css">
</head>
<body>
    <form id="change_pass">
        <h1 class="form__title">The Curve</h1>
        <label for="password">Enter new password</label>
        <input type="password" id="password" placeholder="Enter new password here">
        <label for="cnfrm-password">Confirm password</label>
        <input type="password" id="cnfrm-password" placeholder="Confirm password here">
        <p id="message"></p>
        <input type="button" value="SUBMIT"/>
    </form>
    <script src="/assets/confirm_pass"></script>
</body>
</html>