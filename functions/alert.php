<?php
require_once('redirect.php');

function print_alert()
{
    $types = ['message', 'info', 'error'];
    $colors = ['green', 'grey', 'red'];
    for ($i = 0; $i < count($types); $i++) {
        if (isset($_SESSION[$types[$i]]) && $_SESSION[$types[$i]] != '') {

            echo "<span style='color:" . $colors[$i] . "'>" . $_SESSION[$types[$i]] . "</span>";
            if (!isset($_SESSION['LoggedIn'])) {
                session_destroy();
            } //else {
            //     unset($_SESSION[$types[$i]]);
            // }
        }
    }
}

function set_alert($type = "message", $content = "")
{
    switch ($type) {
        case "message":
            $_SESSION['message'] = $content;
            break;
        case "error":
            $_SESSION['error'] = $content;
            break;
        case "info":
            $_SESSION['info'] = $content;
            break;
        default:
            $_SESSION['message'] = $content;
    }
}


function is_user_LoggedIn()
{
    if (!$_SESSION['loggedIn'] && !empty($_SESSION['loggedIn'])) {
        return true;
    }
    return false;
}

function is_token_set()
{
    return is_token_set_in_get() || is_token_set_in_session();
}

function is_token_set_in_session()
{
    return isset($_SESSION['token']);
}

function is_token_set_in_get()
{
    return isset($_SESSION['token']);
}

function findUser($email = "")
{
    // check database if user exists
    if (!$email) {
        set_alert('error', "User Email is not set");
        die();
    }
    $allUsers = scandir("db/users/"); //return @array (2 filled)

    $countAllUsers = count($allUsers);
    $newUserId = ($countAllUsers - 1);
    // checking user exist
    for ($counter = 0; $counter < $countAllUsers; $counter++) {

        $currentUser = $allUsers[$counter];

        if ($currentUser == $email . ".json") {
            //check the user password.
            $userString = file_get_contents("db/users/" . $email . ".json");
            $userObject = json_decode($userString);
            return $userObject;
        }
    }
    return false;
}

function saveUser($userObject)
{
    file_put_contents("db/users/" . $userObject['email'] . ".json", json_encode($userObject));
}

function updateUser($userObject)
{
}

function generateToken()
{
    $token = "";  // work on token generation

    $alpha = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L"];

    for ($i = 0; $i < 30; $i++) {
        //get random numbers
        //get elements in alphabets at the index of random number
        //add that to the token string
        $tokenTobeGotten = mt_rand(0, count($alpha) - 1);
        $token .= $alpha[$tokenTobeGotten];
    }
    return $token;
}

function sendMail(
    $subject = "",
    $message = "",
    $email = ""
) {
    $subject = "Password reset link";
    $message = "A password reset has been initiated on this account, if you do not initiate this reset,
            please ignore this message. Otherwise, visit: localhost/myh/resetPassword.php?token=" . $token;
    $headers = "From: no-reply@snh.ng" . "\r\n" . "CC:oluwatobilobaoke@snh.ng";
    $sendPasswordReset = mail($email, $subject, $message, $headers);

    if ($sendPasswordReset) {
        // display success message 
        set_alert('message' . "Pasword reset has been sent to your email: " . $email);
        redirect_to("login.php");
    } else {
        // display error message
        set_alert('error' . "Something went wrong we coud not sent password reset link to email: " . $email);
        redirect_to("forgot.php");
    }
}


function findToken($email = "")
{
    $allUserTokens = scandir("db/tokens/"); //return @array (2 filled)

    $countAllUserTokens = count($allUserTokens);

    //scan db array ad check if email already exists
    for ($counter = 0; $counter < $countAllUserTokens; $counter++) {

        $current_Token_File = $allUserTokens[$counter];

        if ($current_Token_File == $email . ".json") {
            // check if token generated match with the session token
            $token_Content_Derived_from_Db = file_get_contents("db/tokens/" . $current_Token_File);
            $token_Object = json_decode($token_Content_Derived_from_Db);
            // $token_from_db = $token_Object->token;

            return $token_Object;
        }
    }
    return false;
}
