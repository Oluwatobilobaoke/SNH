<?php session_start();

require_once('functions/alert.php');
require_once('functions/redirect.php');
require_once('functions/token.php');
require_once('functions/user.php');

// print_r($_POST);

// Collecting the data

$errorCount = 0;

$email = $_POST['email'] != "" ? $_POST['email'] : $errorCount++;

$_SESSION['$email'] = $email;

if ($errorCount > 0) {
    $session_error = "Submission Failed " . $errorCount . " error";
    if ($errorCount > 1) {
        $session_error .= "s";
    }
    $session_error .= '  in your form submmision';
    // $_SESSION['error'] = $session_error;
    set_alert('error', $session_error);
    header("location: forgot.php");
} else {
    // Count all users
    // Assign Id to eachc user,
    // *** Count All the users,
    //save in the database

    $allUsers = scandir("db/users/"); //return @array (2 filled)

    $countAllUsers = count($allUsers);

    for ($counter = 0; $counter < $countAllUsers; $counter++) {

        $currentUser = $allUsers[$counter];

        if ($currentUser == $email . ".json") {
            // send email and redirect to reset password page.

            $token = generateToken();

            $subject = "Password Reset link";
            $message = "A password reset has been initiated on this account, if you do not initiate this reset,
            please ignore this message. Otherwise, visit: localhost/myh/resetPassword.php?token=" . $token;

            file_put_contents("db/tokens/" . $email . ".json", json_encode(["token" => $token]));
            $headers = "From: no-reply@snh.ng" . "\r\n" . "CC:tobiiiiiiiiiii@snh.ng";

            $sendPasswordReset = mail($email, $subject, $message, $headers);
            // print_r($sendPasswordReset);
            // die();

            if ($sendPasswordReset) {
                // display success message 
                set_alert('message', "Pasword reset has been sent to your email: " . $email);
                redirect_to("login.php");
                // die();
            } else {
                // display error message
                set_alert('error', "Something went wrong we coud not sent password reset link to email: " . $email);
                redirect_to("forgot.php");
            }

            die();
        }
    }
    set_alert('error', "Email not registered with us ERR: " . $email);
    redirect_to("forgot.php");
}
