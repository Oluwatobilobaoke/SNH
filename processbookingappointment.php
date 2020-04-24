<?php
session_start();
require_once('functions/alert.php');
require_once('functions/redirect.php');
require_once('functions/token.php');
require_once('functions/user.php');

$userData = json_decode($_SESSION['userObject']);
$errorCount = 0;

$_POST['nature'] !== '' ? $nature = check_input($_POST['nature'])  : $errorCount++;
$_POST['time'] !== '' ? $time = check_input($_POST['time'])  : $errorCount++;
$_POST['date'] !== '' ? $date = $_POST['date']  : $errorCount++;
$_POST['complaint'] !== '' ? $complaint = check_input($_POST['complaint'])  : $errorCount++;

$_POST['department'] !== '' ? $department = check_input($_POST['department'])  : $errorCount++;



$_SESSION['nature'] = $nature;
$_SESSION['time'] = $time;
$_SESSION['date'] = $date;
$_SESSION['department'] = $department;
$_SESSION['complaint'] = $complaint;




if ($errorCount > 0) {
    $session_message = 'Submission failed, you have ' . $errorCount . ' blank field';
    if ($errorCount > 1) {
        $session_message .= "s";
    }
    $session_message .= ' in your form submmision';

    set_alert('error', $session_message);

    redirect_to("bookappointment.php");
    die();
}

if (strlen($complaint) < 5) {

    set_alert('error', "Complaint cannot not be less than 5");
    redirect_to("bookappointment.php");
    die();
} else {



    $time_To_String = strtotime($time);
    $formatted_Time = date('h:i:sa', $timeToString);
    $all_Appointments = scandir('db/appointments/');
    $num_Of_All_Appointments = count($all_Appointments);
    $Id = ($num_Of_All_Appointments - 1);

    $appointMent_Object = [
        'id' => $Id,
        'nature' => $nature,
        'time' => $formatted_Time,
        'date' => $date,
        'department' => $department,
        'complaint' => $complaint,
        "patientName" => $userData->firstname . " " . $userData->lastname
    ];
    // print_r($apointObject);
    // die();


    file_put_contents("db/appointments/" . $Id . ".json", json_encode($appointMent_Object));

    unset($_SESSION['nature']);
    unset($_SESSION['time']);
    unset($_SESSION['date']);
    unset($_SESSION['complaint']);
    unset($_SESSION['department']);
    set_alert('message', "You have successfully submitted an apointment to the " . $department . " department");

    redirect_to("patientDashboard.php");
}
