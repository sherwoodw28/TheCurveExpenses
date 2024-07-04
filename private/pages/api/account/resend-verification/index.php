<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the website instance
    global $website;
    $mail = new Mail;

    // Check the account exists
    if(!$user = $website->getUser()){
        $website->giveApiError('Please ensure you are logged in');
    }

    // Check to see if the user is already verified
    if($user['verified']){
        $website->giveApiError('You are already verified');
    }

    // Resend the email
    $url = $website->getDomain().'/verified?token='.$user['verify_token'];

    // Send the emaik
    $mail->sendMail($user['email'], 'Please confirm your email', str_replace('{{URL}}', $url, (str_replace('{{NAME}}', $user->first_name, file_get_contents(dirname(__FILE__)."/../../../../../email-htmls/verifyEmail.html")))));
    $website->giveApiResponse([
        'status' => 'ok'
    ]);
}