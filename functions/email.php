<?php

require_once('alert.php');
require_once('redirect.php');

function sendMail(
    $subject = "",
    $message = "",
    $email = ""
) {
    // $subject = "Password reset link";
    // $message = "A password reset has been initiated on this account, if you do not initiate this reset,
    //         please ignore this message. Otherwise, visit: localhost/myh/resetPassword.php?token=" . $token;
    $headers = "From: no-reply@snh.org" . "\r\n" .
        "CC: Oluwatobiloba@snh.org";

    $sendPasswordReset = mail($email, $subject, $message, $headers);

    if ($sendPasswordReset) {
        // display success message 
        set_alert('message', "Pasword reset has been sent to your email: " . $email);
        redirect_to("login.php");
    } else {
        // display error message
        set_alert('error', "Something went wrong we coud not sent password reset link to email: " . $email);
        redirect_to("forgot.php");
    }
}
