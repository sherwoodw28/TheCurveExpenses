<?php
    global $website;
    $website->loginRedirect(3);
    
    if(!$token = $_GET['token'] ?: null){
        $website->give_404();
        exit();
    }

    $database = new Database;
    $user = $website->getUser();

    if($user['verify_token'] != $token){
        $website->give_404();
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/verify/verified.css">
</head>    
<body>
    <div class="content">
        <h1>You have successfully verified your email</h1>
        <label for="manager">Choose a manager:</label> <br>

        <select name="manager" id="manager">
        <?php
            $managers = $website->getAllUsers();

            print_r($managers);

            foreach($managers as $manager){
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
