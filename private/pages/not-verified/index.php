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
        <h1>Email verification has been sent</h1>
        <h2>Please check your inbox</h2>
    </div>
</body>
</html>