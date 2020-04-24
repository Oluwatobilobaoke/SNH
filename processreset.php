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
    $countAllUserTokens = count($allUserTokens) - 1;

    for ($counter = 0; $counter < $countAllUserTokens; $counter++) {
        $current_Token_File = $allUserTokens[$counter];
        if (isset($_SESSION['loggedIn'])) {
            $checkedToken = true;
        } else {
            $checkedToken = $current_Token_File == $email . ".json";
        }
        if ($checkedToken) {

            $token_Object = file_get_contents("db/tokens/" . $current_Token_File);
            $token_Content_Derived_from_Db = $token_Object->token;
            if ($token_Content_Derived_from_Db == $token) {
                $allusers = scandir('db/users/');
                $countAllUsers = count($allusers);
                for ($counter = 0; $counter < $countAllUsers; $counter++) {
                    $currentUser = $allusers[$counter];
                    if ($currentUser == $email . ".json") {
                        $userObject = json_decode(file_get_contents('db/users/' . $currentUser));
                        $userObject->password = password_hash($password, PASSWORD_DEFAULT);
                        unlink('db/users/' . $currentUser);
                        unlink('db/tokens/' . $currentToken);
                        file_put_contents("db/users/" . $email . ".json", json_encode($userObject));


                        $subject = "Password Reset Succesful";
                        $message = "Your account on snh has been updated, your password has changed.
                            If you do not request this change, please visit snh.org and reset your password ";
                        $headers = "From: no-reply@snh.ng" . "\r\n" . "CC:Oluwatobiloba@snh.ng";

                        $sendPasswordReset =  mail($email, $subject, $message, $headers);

                        if ($sendPasswordReset) {
                            session_unset();
                            $_SESSION['email'] = $email;
                            set_alert('message', "Password reset successful, you can now login");
                            redirect_to("login.php");
                            die();
                        }
                    }
                }
            }
        }
    }

    set_alert('error', "Password Reset Failed Mahn, token/email invalid or expired " . $first_name);
    redirect_to("login.php");
}
