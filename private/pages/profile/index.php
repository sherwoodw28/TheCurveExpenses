<?php
    global $website;
    $website->loginRedirect(1);

    $user = $website->getUser();

    $accountTools = new AccountTools;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/profile/style.css">
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <title>Profile - The Curve</title>
</head>

<body>
    <div class="container">
        <div class="user-image">
            <img onclick="window.location.href = 'https://wordpress.com/log-in/link?client_id=1854&redirect_to=https%3A%2F%2Fpublic-api.wordpress.com%2Foauth2%2Fauthorize%3Fclient_id%3D1854%26response_type%3Dcode%26blog_id%3D0%26state%3D28b1ab4b99d70f4587971b4ee8635d24f473e249e42b6645420088011e792ed4%26redirect_uri%3Dhttps%253A%252F%252Fgravatar.com%252Fconnect%252F%253Faction%253Drequest_access_token%26from-calypso%3D1'" style="cursor: pointer;" src="<?php echo $accountTools->getPFP($website->getUser()['email']);?>" alt="User Image">
        </div>
        <div class="content">
            <input type="text" id="Name" name="Name" placeholder="<?php echo $website->getUser()['first_name'];?> <?php echo $website->getUser()['last_name'];?>" value="<?php echo $website->getUser()['first_name'];?> <?php echo $website->getUser()['last_name'];?>" value="<?php echo $website->getUser()['first_name'];?>">
            
            <label for="manager">Choose a manager:</label>
            <select name="manager" id="manager">
            <?php
            $managers = $website->getAllUsers();


            foreach($managers as $manager){
                if($manager['id'] != $user['id']){
                    echo '<option value="'.$manager['id'].'">'.$manager['first_name'].' '.$manager['last_name'].'</option>';
                }
            }
            ?>
            </select>
            <script> document.querySelector('#manager').value = '<?php echo $user['manager'];?>'; </script>
            
            <a href="/reset-password" class="change-password-link">Change Password</a>
            <a href="/api/account/logout/" class="logout">Logout of Account</a>
            <script src="/assets/profile/script.js"></script>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/704ff50790.js" crossorigin="anonymous"></script>
</body>

</html>
