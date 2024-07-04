<?php
    global $website;
    $website->loginRedirect(1);

    $accountTools = new AccountTools;
    $user = $website->getUser();

    $requests = $website->getRequests($user, '0');
    $requests2 = $website->getRequests($user, '1');
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
                <button onclick="window.location.href = '/expense-form';" class="header-btn">New Form</button>
            </div>
        </header>
        <main>
            <section id="user">
                <div class="card">
                    <h3>To Review</h3>
                    <select id="payment-options" name="payment-options">
                        <option value="" disabled selected hidden><?php echo $count.' new forms available';?></option>
                        <?php
                            foreach ($requests as $request) {
                                $userRecordFor = $website->getUser($website->getUser($request['user'])['id']);
                                echo  '<option data-name="'.htmlspecialchars($userRecordFor['first_name']).
                                ' '.htmlspecialchars($userRecordFor['last_name']).
                                '" data-email="'.htmlspecialchars($userRecordFor['email']).
                                '" data-reason="'.htmlspecialchars($request['reason']).
                                '" data-details="'.htmlspecialchars($request['details']).
                                '" data-date="'.htmlspecialchars($request['date']).
                                '" data-endDate="'.htmlspecialchars($request['dateAfter']).
                                '" data-cost="'.htmlspecialchars($request['expenses']).
                                '" data-id="'.$request['id'].
                                '" data-endDate="'.htmlspecialchars($request['dateAfter']).
                                '" data-timestamp="'.htmlspecialchars($request['timestamp']).
                                '">'.htmlspecialchars($userRecordFor['first_name']).' '.
                                htmlspecialchars($userRecordFor['last_name']).'</option>';
                            }
                        ?>
                    </select>
                    <div id="payment-details" class="dropdown-content">
                        <p><strong>Submitted By:</strong> <span id="payment-submitted-by">John Doe</span></p>
                        <p><strong>Request Details:</strong></p>
                        <ul id="payment-request-details">
                            <li>Lorem ipsum dolor sit amet.</li>
                        </ul>
                        <p><strong>Submission Date:</strong> <span id="payment-submission-date">2023-07-01 12:00 PM</span></p>
                        <a href="/view-receipt?id=" target="_blank" class="view-rec">View Receipts</a><br><br>
                        <button id="payment-approve-btn" class="approve-btn">Confirm Approval</button>
                    </div>
                </div>
                <div class="card">
                    <h3>To Be Paid</h3>
                    <select id="renew-options" name="renew-options">
                        <option value="" disabled selected hidden><?php echo $count.' new forms available';?></option>
                        <?php
                            $count = 0;
                            foreach ($requests2 as $request) {
                                $count++;
                                $userRecordFor = $website->getUser($website->getUser($request['user'])['id']);
                                echo  '<option data-name="'.htmlspecialchars($userRecordFor['first_name']).
                                ' '.htmlspecialchars($userRecordFor['last_name']).
                                '" data-email="'.htmlspecialchars($userRecordFor['email']).
                                '" data-reason="'.htmlspecialchars($request['reason']).
                                '" data-details="'.htmlspecialchars($request['details']).
                                '" data-date="'.htmlspecialchars($request['date']).
                                '" data-endDate="'.htmlspecialchars($request['dateAfter']).
                                '" data-cost="'.htmlspecialchars($request['expenses']).
                                '" data-id="'.$request['id'].
                                '" data-endDate="'.htmlspecialchars($request['dateAfter']).
                                '" data-timestamp="'.htmlspecialchars($request['timestamp']).
                                '">'.htmlspecialchars($userRecordFor['first_name']).' '.
                                htmlspecialchars($userRecordFor['last_name']).'</option>';
                            }
                        ?>
                    </select>
                    <div id="renew-details" class="dropdown-content">
                        <p><strong>Submitted By:</strong> <span id="renew-submitted-by">Jane Doe</span></p>
                        <p><strong>Request Details:</strong></p>
                        <ul id="renew-request-details">
                            <li>Consectetur adipiscing elit.</li>
                        </ul>
                        <p><strong>Submission Date:</strong> <span id="renew-submission-date">2023-07-02 1:00 PM</span></p>
                        <a href="/view-receipt?id=" target="_blank" class="view-rec">View Receipts</a><br><br>
                        <button id="renew-approve-btn" class="approve-btn">Confirm Payment</button>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="/assets/dashboard/dash.js"></script>
</body>
</html>
