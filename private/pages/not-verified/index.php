<?php
    global $website;
    $website->loginRedirect(3);

    $accountTools = new AccountTools;

    if($website->getUser()['verified']){
        header('location: /dashboard');
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/verify/style.css">
    <link rel="shortcut icon" href="/assets/favicon.ico">
</head>
<body>
    <div class="content">
        <h1>Please verify your email.</h1>
        <h2>A verification email has been sent to your inbox!</h2>
        <button id="resend-button">Resend Email</button>
    </div>
</body>
</html>
