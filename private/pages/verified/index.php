<?php
    global $website;
    $website->loginRedirect(3);
    
    if (!$token = $_GET['token'] ?: null) {
        header('location: /dashboard');
        exit();
    }

    $database = new Database;
    $stmt = $database->exe("SELECT * FROM `users` WHERE `verify_token` = ?", [$token]);

    if ($stmt) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if (!$user) {
            header('location: /dashboard');
            exit();
        }
    }

    if ($user['verify_token'] != $token) {
        header('location: /dashboard');
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/verify/verified.css">
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/f909ddf2bf.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="content">
        <h1>You have successfully verified your email</h1>
        <label for="manager">Choose a manager:</label> <br>

        <div class="dropdown">
            <button id="dropdownButton" onclick="toggleDropdown()" class="dropbtn">Choose a Manager <i class="fa-solid fa-angle-down"></i></button>
            <div id="myDropdown" class="dropdown-content">
                <?php
                    // Gets all users from the database.
                    $managers = $website->getAllUsers();
                    // Iterates through users that exist, takes the ID, First and Last Name
                    foreach ($managers as $manager) {
                        // Makes sure self is not in list.
                        if ($manager['id'] != $user['id']) {
                            echo '<a href="#" data-id="'.$manager['id'].'">'.$manager['first_name'].' '.$manager['last_name'].'</a>';
                        }
                    }
                ?>
            </div>
        </div>
        
        <button class="confirm-button">Confirm</button>
    </div>

    <div class="footer">
        <p>You can change your manager at a later time.</p>
    </div>
</body>
</html>
<script>
    function toggleDropdown() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }

    document.querySelectorAll('#myDropdown a').forEach(item => {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelectorAll('#myDropdown a').forEach(link => {
            link.classList.remove('selected');
        });
        item.classList.add('selected');
        document.getElementById('dropdownButton').innerHTML = item.innerText + ' <i class="fa-solid fa-angle-down"></i>';
    });
});


    const verifyButton = document.querySelector('.confirm-button');
    verifyButton.addEventListener("click", async (e) => {
        e.preventDefault();
    
        try {
            const selectedManager = document.querySelector('#myDropdown a.selected');
            if (!selectedManager) {
                alert("Please select a manager.");
                return;
            }
            const manager = selectedManager.getAttribute('data-id');
            const token = <?php echo json_encode($token); ?>;
    
            const request = await fetch("/api/account/verify", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ manager, token })
            });
    
            if (!request.ok) {
                throw new Error('Network response was not ok');
            }
    
            const response = await request.json();
    
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
