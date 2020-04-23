<?php session_start();
require_once('functions/alert.php');
require_once('functions/redirect.php');

// print_r($_POST);

// Collecting the data

$errorCount = 0;

if (!is_user_LoggedIn()) {
    $token = $_POST['token'] != "" ? $_POST['token'] : $errorCount++;
    $_SESSION['token'] = $token;
}

$email = $_POST['email'] != "" ? $_POST['email'] : $errorCount++;
$password = $_POST['password'] != "" ? $_POST['password'] : $errorCount++;



$_SESSION['email'] = $email;



if ($errorCount > 0) {
    $session_error = "Submission Failed " . $errorCount . " error";
    if ($errorCount > 1) {
        $session_error .= "s";
    }
    $session_error .= '  in your form submmision';

    set_alert('erorr', $session_error);

    redirect_to("resetpassword.php");
} else {
    // do the reset 

    // check email exits in tokens folder on the database
    // check if token generated match with the session token
    //save in the database

    $checkToken = is_user_LoggedIn() ? true : findToken($email);

    if ($checkToken) {

        $userExists = findUser($email);


        if ($userExists) {
            //check the user password.
            $userObject = findUser($email);

            $userObject->password = password_hash($password, PASSWORD_DEFAULT);

            unlink("db/users/" . $currentUser);
            unlink("db/tokens/" . $currentUser);

            saveUser($userObject);


            set_alert('message', "Password Reset Successful, you can now login " . $first_name);
            /**
             * Inform User of password reset starts
             */
            $subject = "Password reset successful";
            $message = "your account password has just beeen updated, if you didnt initiate password change visit snh.org and reset the passwords immediately.";
            sendMail($subject, $message, $email);
            /**
             * Inform User of password reset ends
             */
            redirect_to("login.php");


            // echo "User can update password";
            return;
        }
    }




    set_alert('error', "Password Reset Failed Mahn, token/email invalid or expired " . $first_name);
    redirect_to("login.php");
}
