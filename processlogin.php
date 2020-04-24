<?php
session_start();
require_once('functions/alert.php');
require_once('functions/redirect.php');
require_once('functions/token.php');
require_once('functions/user.php');


$errorCount = 0;

$_POST['email'] !== '' ? $email = $_POST['email'] : $errorCount++;
$_POST['password'] !== '' ? $password = $_POST['password'] : $errorCount++;

$_SESSION['email'] = $email;


if ($errorCount > 0) {
    $session_error = "Submission Failed " . $errorCount . " error";
    if ($errorCount > 1) {
        $session_error .= "s";
    }
    $session_error .= '  in your form submmision';
    set_alert("error", $session_error);
    redirect_to("login.php");
} else {

    $currentUser = findUser($email);
    // print_r($currentUser);
    // die();

    if ($currentUser) {
        //check the user password.
        $userString = file_get_contents("db/users/" . $currentUser->email . ".json");
        $userObject = json_decode($userString);

        $passwordFromDB = $userObject->password;

        $password_inputed_By_User = password_verify($password, $passwordFromDB);

        if ($passwordFromDB == $password_inputed_By_User) {
            //last login capture
            // file_put_contents("db/login/" . $email . ".json", json_encode(['last_login' => $lastlog]));

            //redirect to dashboard
            $_SESSION['email'] =  $userObject->email;
            $_SESSION['userObject'] = json_encode($userObject);
            $_SESSION['loggedIn'] = $userObject->id;
            $_SESSION['role'] = $userObject->designation;


            if ($userObject->designation == "Medical Team (MT)") {
                redirect_to("dashboard.php");
                die();
            }
            if ($userObject->designation == 'Patient') {
                redirect_to("patientDashBoard.php");
                die();
            }
            if ($userObject->designation == 'Super Admin') {
                redirect_to("superAdminDashboard.php");
                die();
            }
        }
    }
    set_alert("error", 'Invalid Email or Password');
    redirect_to("login.php");
    die();
}
