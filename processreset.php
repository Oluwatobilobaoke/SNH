<?php session_start();
// require_once('functions/user.php');
require_once('functions/alert.php');
require_once('functions/redirect.php');
// require_once('functions/user.php');


// print_r($_POST);

// Collecting the data

$errorCount = 0;

if (!$_SESSION['loggedIn']) {

    $token = $_POST['token'] != "" ? $_POST['token'] :  $errorCount++;
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
    // if ($current_Token_File == $email . ".json") {
    //     // check if token generated match with the session token
    //     $token_Content_Derived_from_Db = file_get_contents("db/tokens/" . $current_Token_File);
    //     $token_Object = json_decode($token_Content_Derived_from_Db);
    //     $token_from_db = $token_Object->token;

    $allUserTokens = scandir("db/tokens/"); //return @array (2 filled)
    $countAllUserTokens = count($allUserTokens);

    for ($counter = 0; $counter < $countAllUserTokens; $counter++) {

        $current_Token_File = $allUserTokens[$counter];

        if ($current_Token_File == $email . ".json") {
            //now check if the token in the currentTokenFile is the same as $token
            $token_Content_Derived_from_Db = file_get_contents("db/tokens/" . $current_Token_File);

            $token_Object = json_decode($token_Content_Derived_from_Db);
            $token_from_db = $token_Object->token;

            //TODO: Make this better, fix the temporary fix

            if ($_SESSION['loggedIn']) {
                $checkToken = true;
            } else {
                $checkToken = $token_from_db == $token;
            }

            if ($checkToken) {

                $allUsers = scandir("db/users/");
                $countAllUsers = count($allUsers);

                for ($counter = 0; $counter < $countAllUsers; $counter++) {

                    $currentUser = $allUsers[$counter];

                    if ($currentUser == $email . ".json") {
                        //check the user password.
                        $userString = file_get_contents("db/users/" . $currentUser);
                        $userObject = json_decode($userString);

                        $userObject->password = password_hash($password, PASSWORD_DEFAULT);

                        unlink("db/users/" . $currentUser); //file delete, user data delete
                        unlink("db/token/" . $currentUser); //file delete, token data delete
                        //save_user($userObject);
                        file_put_contents("db/users/" . $email . ".json", json_encode($userObject));
                        set_alert('message', 'Password Reset Successful, you can now login');

                        $subject = "Password Reset Successful";
                        $message = "Your account on snh has just been updated, your password has changed. if you did not initiate the password change, please visit snh.org and reset your password immediatly";
                        $headers = "From: no-reply@snh.org" . "\r\n" .
                            "CC: OLuwatobioba@snh.org";

                        $try = mail($email, $subject, $message, $headers);
                        redirect_to("login.php");
                        die();
                    }
                }
            }
        }
    }
    set_alert('error', "Password Reset Failed Mahn, token/email invalid or expired " . $first_name);
    redirect_to("login.php");
}
