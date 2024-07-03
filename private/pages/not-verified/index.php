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
<script>
    document.querySelector('#resend-button').addEventListener('click', async()=>{
        try {
            // Perform your AJAX/Fetch logic
            const request = await fetch("/api/account/resend-verification", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                }
            });
        
            // Check if the request was successful
            if (!request.ok) {
                throw new Error('Network response was not ok');
            }
        
            // Parse the response as JSON
            const response = await request.json();
        
            // Check for errors in the response and set the form message accordingly
            if (response.error) {
                alert(response.error);
            } else{
                alert('Verification email re-sent');
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            alert("An error occurred re-sending the verification email");
        }
    });
</script>