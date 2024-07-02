<?php
    global $website;
    $website->loginRedirect(3);

    $accountTools = new AccountTools;

    if($website->getUser()['verified']){
        header('location: /dashboard');
        exit();
    }
?>


<p>Please verify your email!</p>