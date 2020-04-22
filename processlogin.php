<?php
// require_once('./functions/alert.php');
session_start();

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
    $_SESSION['error'] = $session_error;
    header("location: login.php");
} else {


    $allUsers = scandir("db/users/");    //collecting all users in database
    $countAllUsers = count($allUsers);   // counting all users

    // checking user exist
    for ($counter = 0; $counter < $countAllUsers; $counter++) {

        $currentUser = $allUsers[$counter];

        if ($currentUser == $email . ".json") {
            //check the user password.
            $userString = file_get_contents("db/users/" . $email . ".json");
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
                    header("Location: dashboard.php");
                    die();
                }
                if ($userObject->designation == 'Patient') {
                    header("Location: patientDashBoard.php");
                    die();
                }
                if ($userObject->designation == 'Super Admin') {
                    header("Location: superAdminDashboard.php");
                    die();
                }
            }
        }
    }
    $_SESSION['error'] = 'Invalid Email or Password';
    header("Location: login.php");
    die();
}
