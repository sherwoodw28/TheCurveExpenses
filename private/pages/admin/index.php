<?php
    global $website;
    $website->loginRedirect(1);

    $accountTools = new AccountTools;
    $user = $website->getUser();
    if(!$user['admin']){
        $website->give_404();
        exit();
    }

    $users = $website->getAllUsers();
    $records = [];
    $records = array_merge($records, $website->getRequests(false, 1));
    $records = array_merge($records, $website->getRequests(false, 2));
    $records = array_merge($records, $website->getRequests(false, -1));
    $records = array_merge($records, $website->getRequests(false, 0));
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Administration</title>
<style>
    a#update{
        width: 100%;
        padding: 15px 0 15px 0;
        text-decoration: none;
        background-color: red;
        display: block;
        text-align: center;
        border-radius: 15px;
        color: white;
        font-weight: bold;
        font-size: 20px;
        margin: 20px 0;
        cursor: pointer;
    }
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ccc;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    td input[type="text"] {
        width: 100%;
        box-sizing: border-box;
        padding: 5px;
    }
    td input[type="checkbox"] {
        margin-left: 5px;
    }
    .editable {
        cursor: pointer;
    }
</style>
</head>
<body>

<h2>User Administration</h2>

<table id="usersTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Manager</th>
            <th>Admin</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($users as $localUser) {
                echo 
                "<tr>
                    <td>".$localUser['id']."</td>
                    <td contenteditable=\"true\">".$localUser['first_name']."</td>
                    <td contenteditable=\"true\">".$localUser['last_name']."</td>
                    <td contenteditable=\"true\">".$localUser['email']."</td>
                    <td>".$localUser['date']."</td>
                    <td contenteditable=\"true\">".$localUser['manager']."</td>
                    <td contenteditable=\"true\">".($localUser['admin'] ? 'true' : 'false')."</td>
                    <td><a style='cursor: pointer;' id='del'>Delete</a></td>
                </tr>";
            }
        ?>
    </tbody>
</table>

<h2>User Records</h2>

<table id="recordsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Reason</th>
            <th>Details</th>
            <th>Timestamp</th>
            <th>Date From</th>
            <th>Date After</th>
            <th>Status</th>
            <th>Expenses</th>
            <th>Assistance</th>
            <th>Comment</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    <?php
            foreach ($records as $localRecords) {
                echo 
                "<tr>
                    <td>".$localRecords['id']."</td>
                    <td contenteditable=\"true\">".$localRecords['user']."</td>
                    <td contenteditable=\"true\">".$localRecords['reason']."</td>
                    <td contenteditable=\"true\">".$localRecords['details']."</td>
                    <td>".$localRecords['timestamp']."</td>
                    <td contenteditable=\"true\">".$localRecords['date']."</td>
                    <td contenteditable=\"true\">".$localRecords['dateAfter']."</td>
                    <td contenteditable=\"true\">".$localRecords['status']."</td>
                    <td contenteditable=\"true\">".$localRecords['expenses']."</td>
                    <td contenteditable=\"true\">".($localRecords['assistance'] ? 'true' : 'false')."</td>
                    <td contenteditable=\"true\">".$localRecords['comment']."</td>
                    <td><a style='cursor: pointer;' id='del2'>Delete</a></td>
                </tr>";
            }
        ?>
    </tbody>
</table>
<a id="update">Update</a>
<script>
    // Update script
    document.querySelector('a#update').addEventListener('click', async()=>{
        Array.from(document.querySelector('#usersTable').querySelector('tbody').querySelectorAll('.changed')).forEach(async(element)=> {
            const id = element.children[0].textContent;
            const fName = element.children[1].textContent;
            const lName = element.children[2].textContent;
            const email = element.children[3].textContent;
            // Gap because date not needed
            const manager = element.children[5].textContent;
            const admin = (element.children[6].textContent === 'true') ? '1' : '0';

            try {
                // Perform your AJAX request
                const request = await fetch("/api/admin/update", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ id, fName, lName, email, manager, admin })
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
                }
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                alert(error);
            }
        });
    })
    document.querySelectorAll('a#del').forEach(item => {
        item.addEventListener('click', async (event) => {
            try {
                const id = event.target.parentElement.parentElement.children[0].innerText; // Adjust this according to your HTML structure

                // Perform your AJAX request
                const request = await fetch("/api/admin/user/delete", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ id })
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
                    event.target.parentElement.parentElement.remove();
                }
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                alert(error);
            }
        });
    });

    document.querySelector('a#update').addEventListener('click', async()=>{
        Array.from(document.querySelector('#recordsTable').querySelector('tbody').querySelectorAll('.changed')).forEach(async(element)=> {
            const id = element.children[0].textContent;
            const user = element.children[1].textContent;
            const reason = element.children[2].textContent;
            const details = element.children[3].textContent;
            // Gap because date not needed
            const date = element.children[5].textContent;
            const dateAfter = element.children[6].textContent;
            const status = element.children[7].textContent;
            const expenses = element.children[8].textContent;
            const assistance = (element.children[9].textContent === 'true') ? '1' : '0';
            const comment = element.children[10].textContent;

            try {
                // Perform your AJAX request
                const request = await fetch("/api/admin/updateR", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ id, user, reason, details, date, dateAfter, status, expenses, assistance, comment })
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
                }
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                alert(error);
            }
        });
        alert('Success');
    })
    document.querySelectorAll('a#del2').forEach(item => {
        item.addEventListener('click', async (event) => {
            try {
                const id = event.target.parentElement.parentElement.children[0].innerText; // Adjust this according to your HTML structure

                // Perform your AJAX request
                const request = await fetch("/api/admin/record/delete", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ id })
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
                    event.target.parentElement.parentElement.remove();
                }
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                alert(error);
            }
        });
    });

    // Set what has changed
    document.querySelectorAll('td').forEach(item => {
        item.addEventListener('input', async (event) => {
            item.parentElement.classList.add('changed');
        });
    });
</script>

</body>
</html>