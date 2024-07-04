<?php
    global $website;
    $website->loginRedirect(3);
    
    if(!$token = $_GET['token'] ?: null){
        header('location: /dashboard');
        exit();
    }

    $database = new Database;
    $stmt = $database->exe("SELECT * FROM `users` WHERE `verify_token` = ?", [$token]);


    if ($stmt) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if(!$user){
            header('location: /dashboard');
            exit();
        }
    }

    if($user['verify_token'] != $token){
        header('location: /dashboard');
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/verify/verified.css">
    <link rel="shortcut icon" href="/assets/favicon.ico">
</head>    
<body>
    <div class="content">
        <h1>You have successfully verified your email</h1>
        <label for="manager">Choose a manager:</label> <br>

        <select name="manager" id="manager">
        <?php
            //Gets all users from the database.
            $managers = $website->getAllUsers();
            //Iterates through users that exist, takes the ID, First and Last Name
            foreach($managers as $manager){
                //Makes sure self is not in list.
                if($manager['id'] != $user['id']){
                    echo '<option value="'.$manager['id'].'">'.$manager['first_name'].' '.$manager['last_name'].'</option>';
                }
            }
        ?>
        </select>
        
        <button class="confirm-button">Confirm</button>
    </div>

    <div class="footer">
        <p>You can change your manager at a later time.</p>
    </div>
</body>
</html>
<script>
    const verifyButton = document.querySelector('.confirm-button');
    verifyButton.addEventListener("click", async (e) => {
        e.preventDefault();
    
        try {
            // Get the values from the form inputs
            const manager = document.querySelector('#manager').value;
            const token = <?php echo json_encode($token); ?>;
    
            // Perform your AJAX/Fetch login
            const request = await fetch("/api/account/verify", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ manager, token })
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
            } else {
                window.location.href = "/dashboard";
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            alert("An error occurred during verification.");
        }
    });
</script>