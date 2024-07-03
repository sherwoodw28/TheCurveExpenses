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
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <title>Dashboard - The Curve</title>
    <link rel="stylesheet" href="/assets/dashboard/style.css">
</head>
<body>
    <div class="container">
        <header>
            <img onclick="window.location.href = '/profile'" style="cursor: pointer;" src="<?php echo $accountTools->getPFP($website->getUser()['email']);?>" alt="Profile Picture" class="profile-picture">
            <h1 onclick="window.location.href = '/profile'" style="cursor: pointer;">Welcome, <?php echo $website->getUser()['first_name'];?></h1>
            <div class="header-buttons">
                <button onclick="window.location.href = '/expense_form';" class="header-btn">New Form</button>
            </div>
        </header>
        <main>
            <section id="user">
                <div class="card">
                    <h3>To Review</h3>
                    <select id="payment-options" name="payment-options">
                        <option value="" disabled selected hidden>Select an option</option>
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                        <option value="option4">Option 4</option>
                        <option value="option5">Option 5</option>
                    </select>
                    <div id="payment-details" class="dropdown-content">
                        <p><strong>Submitted By:</strong> <span id="payment-submitted-by">John Doe</span></p>
                        <p><strong>Request Details:</strong></p>
                        <ul id="payment-request-details">
                            <li>Lorem ipsum dolor sit amet.</li>
                        </ul>
                        <p><strong>Submission Date:</strong> <span id="payment-submission-date">2023-07-01 12:00 PM</span></p>
                        <button id="payment-approve-btn" class="approve-btn">Confirm Approval</button>
                    </div>
                </div>
                <div class="card">
                    <h3>To Be Paid</h3>
                    <select id="renew-options" name="renew-options">
                        <option value="" disabled selected hidden>Select an option</option>
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                        <option value="option4">Option 4</option>
                        <option value="option5">Option 5</option>
                    </select>
                    <div id="renew-details" class="dropdown-content">
                        <p><strong>Submitted By:</strong> <span id="renew-submitted-by">Jane Doe</span></p>
                        <p><strong>Request Details:</strong></p>
                        <ul id="renew-request-details">
                            <li>Consectetur adipiscing elit.</li>
                        </ul>
                        <p><strong>Submission Date:</strong> <span id="renew-submission-date">2023-07-02 1:00 PM</span></p>
                        <button id="renew-approve-btn" class="approve-btn">Confirm Payment</button>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="/assets/dashboard/style.js"></script>
</body>
</html>
