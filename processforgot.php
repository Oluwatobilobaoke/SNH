<?php session_start();

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
    $_SESSION['error'] = $session_error;
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
            $token = "";  // work on token generation

            $alpha = ["a", "b", "c", "d", "e", "f", "g", "h", "A", "B", "C", "D", "E", "F", "G", "H"];

            $subject = "Password reset link";
            $message = "A password reset has been initiated on this account, if you do not initiate this reset,
            please ignore this message. Otherwise, visit: localhost/myh/resetPassword.php?token=" . $token;
            $headers = "From: no-reply@snh.ng" . "\r\n" . "CC:oluwatobilobaoke@snh.ng";
            file_put_contents("db/tokens/" . $email . ".json", json_encode(["token " => $token]));
            $sendPasswordReset = mail($email, $subject, $message, $headers);

            if ($sendPasswordReset) {
                // display success message 
                $_SESSION['error'] = 'Password reset link has be sent to your email: ' . $email;
                header("Location: login.php");
            } else {
                // display error message
                $_SESSION["error"] = "Something went wrong we coud not sent password reset link to email: " . $email;
                header("Location: forgot.php");
            }

            die();
        }
    }
    $_SESSION["error"] = "Email not registered with us ERR: " . $email;
    header("Location: forgot.php");
}
