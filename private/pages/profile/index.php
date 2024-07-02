<?php
    global $website;
    $website->loginRedirect(1);

    $accountTools = new AccountTools;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/profile/style.css">
    <title>Profile - The Curve</title>
</head>

<body>
    <div class="container">
        <div class="user-image">
            <img src="<?php echo $accountTools->getPFP($website->getUser()['email']);?>" alt="User Image">
        </div>
        <div class="content">
            <input type="text" id="Name" name="Name" placeholder="<?php echo $website->getUser()['first_name'];?>" value="<?php echo $website->getUser()['first_name'];?>">
            
            <label for="manager">Choose a manager:</label>
            <select name="manager" id="manager">
                <option value="1">Manager 1</option>
                <option value="2">Manager 2</option>
                <option value="3">Manager 3</option>
                <option value="4">Manager 4</option>
                <option value="5">Manager 5</option>
            </select>
            
            <a href="resetpass.html" class="change-password-link">Change Password</a>
            <a href="logout.php" class="logout">Logout of Account</a>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/704ff50790.js" crossorigin="anonymous"></script>
</body>

</html>
