<?php
    global $website;
    $website->loginRedirect(1);

    $accountTools = new AccountTools;
    $user = $website->getUser();

    $requests = $website->getRequests($user, '0');
    $requests2 = $website->getRequests($user, '1');
    $requests3 = $website->getRequests($user, '2');
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
                <button onclick="window.location.href = '/expense-form';" class="header-btn"> + New Form</button>
            </div>
        </header>
        <div id="main">
            <div class="card" id="review">
                <h2 class="title">Review</h2>
                <?php
                    foreach ($requests as $request) {
                        $userRecordFor = $website->getUser($website->getUser($request['user'])['id']);
                        echo '<div class="item" data-name="'.htmlspecialchars($userRecordFor['first_name']).
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
                        '" data-comment="'.htmlspecialchars($request['comment']).
                        '">'.'<img src="https://site-assets.fontawesome.com/releases/v6.5.2/svgs/solid/grip.svg">'.
                        '<h3 class="name">'.htmlspecialchars($request['reason']).' ('.
                        htmlspecialchars($userRecordFor['first_name']).' '.
                        htmlspecialchars($userRecordFor['last_name']).')</h3></div>';
                    }
                ?>
            </div>

            <div class="card" id="approve">
                <h2 class="title">Approved</h2>
                <?php
                    foreach ($requests2 as $request) {
                        $userRecordFor = $website->getUser($website->getUser($request['user'])['id']);
                        echo '<div class="item" data-name="'.htmlspecialchars($userRecordFor['first_name']).
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
                        '" data-comment="'.htmlspecialchars($request['comment']).
                        '">'.'<img src="https://site-assets.fontawesome.com/releases/v6.5.2/svgs/solid/grip.svg">'.
                        '<h3 class="name">'.htmlspecialchars($request['reason']).'('.
                        htmlspecialchars($userRecordFor['first_name']).' '.
                        htmlspecialchars($userRecordFor['last_name']).')</h3></div>';
                    }
                ?>
            </div>

            <div class="card" id="renew">
                <h2 class="title">Paid</h2>
                <?php
                    foreach ($requests3 as $request) {
                        $userRecordFor = $website->getUser($website->getUser($request['user'])['id']);
                        echo '<div class="item" data-name="'.htmlspecialchars($userRecordFor['first_name']).
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
                        '" data-comment="'.htmlspecialchars($request['comment']).
                        '">'.'<img src="https://site-assets.fontawesome.com/releases/v6.5.2/svgs/solid/grip.svg">'.
                        '<h3 class="name">'.htmlspecialchars($request['reason']).'('.
                        htmlspecialchars($userRecordFor['first_name']).' '.
                        htmlspecialchars($userRecordFor['last_name']).')</h3></div>';
                    }
                ?>
            </div>

            <div class="trash">
                <img src="https://site-assets.fontawesome.com/releases/v6.5.2/svgs/solid/trash-can.svg" alt="" srcset="">
            </div>
            <div class="popup" style="display: none;">
                <img src="https://site-assets.fontawesome.com/releases/v6.5.2/svgs/solid/circle-xmark.svg" alt="">
                <h3 class="title">POPUP NAME</h3>
                <p class="content">
                    <b>Submitted By:</b> NAME (EMAIL) <br>
                    <b>Reason:</b> REASON <br>
                    <b>Details:</b> DETAILS <br>
                    <b>Date From:</b> DATE FROM <br>
                    <b>Date To:</b> DATE TO <br>
                    <b>Total Cost:</b> COST <br>
                    <b>Comment:</b> COMMENT <br>
                    <b>Submission Date:</b> DATE <br>
                    <a href="">View Receipts</a>
                </p>
            </div>
        </div>
    </div>
    <script src="/assets/dashboard/dash.js"></script>
</body>
</html>
