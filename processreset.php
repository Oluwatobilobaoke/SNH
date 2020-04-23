<?php session_start();

// print_r($_POST);

// Collecting the data

$errorCount = 0;

if (!$_SESSION['loggedIn']) {
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
    $_SESSION['error'] = $session_error;
    header("location: resetpassword.php");
} else {
    // do the reset 

    // check email exits in tokens folder on the database
    // check if token generated match with the session token
    //save in the database

    $allUserTokens = scandir("db/tokens/"); //return @array (2 filled)

    $countAllUserTokens = count($allUserTokens);

    //scan db array ad check if email already exists
    for ($counter = 0; $counter < $countAllUserTokens; $counter++) {

        $current_Token_File = $allUserTokens[$counter];

        if ($current_Token_File == $email . ".json") {
            // check if token generated match with the session token
            $token_Content_Derived_from_Db = file_get_contents("db/tokens/" . $current_Token_File);
            $token_Object = json_decode($token_Content_Derived_from_Db);
            $token_from_db = $token_Object->token;
            // print_r($token_from_db);
            // die();

            if ($_SESSION['loggedIn']) {
                $checkToken = true;
            } else {
                $checkToken = $token_from_db == $token;
            }


            if ($checkToken) {


                $allUsers = scandir("db/users/");    //collecting all users in database
                $countAllUsers = count($allUsers);

                // counting all users
                // checking user exist
                for ($counter = 0; $counter < $countAllUsers; $counter++) {

                    $currentUser = $allUsers[$counter];

                    if ($currentUser == $email . ".json") {
                        //check the user password.
                        $userString = file_get_contents("db/users/" . $currentUser);

                        $userObject = json_decode($userString);

                        $userObject->password = password_hash($password, PASSWORD_DEFAULT);

                        unlink("db/users/" . $currentUser);

                        file_put_contents("db/users/" . $email . ".json", json_encode($userObject));

                        $_SESSION["message"] = "Password Reset Successful, you can now login " . $first_name;
                        /**
                         * Inform User of password reset starts
                         */
                        $subject = "Password reset successful";
                        $message = "your account password has just beeen updated, if you didnt initiate password change visit snh.org and reset the passwords immediately.";
                        $headers = "From: no-reply@snh.ng" . "\r\n" . "CC:oluwatobilobaoke@snh.ng";

                        $sendPasswordReset = mail($email, $subject, $message, $headers);
                        /**
                         * Inform User of password reset ends
                         */
                        header("Location: login.php");


                        // echo "User can update password";
                        die();
                    }
                }
            }
        }
    }

    $_SESSION["error"] = "Password Reset Failed Mahn, token/email invalid or expired " . $first_name;
    header("Location: login.php");
}
