<?php

include_once('lib/header.php');
require_once('functions/alert.php');
require_once('functions/tables.php');


if (!isset($_SESSION['loggedIn']) || $_SESSION['role'] !== "Medical Team (MT)") {
    set_alert('error', "You have not login");
    header("location:login.php");
}

$userData = json_decode($_SESSION['userObject']);
?>

<section>
    <div id="table">
        <!-- <h1>Appointment Table for <?php echo $userData->department ?> Department</h1> -->
        <a class="btn btn-outline-danger" href="dashboard.php" style="margin: 20px">; Back</a>
        <?php
        $rows = getAppointments($userData->department);
        if ($rows) {

        ?>
            <table class="table table-bordered">
                <caption>
                    <?php echo $userData->department ?> Department Appointments</caption>
                <thead class="thead-dark ">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">Nature of Apointment</th>
                        <th scope="col">Appointment Date</th>
                        <th scope="col">Appointment Time</th>
                        <th scope="col">Department</th>
                        <th scope="col">Initial Complaint</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $rows; ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>You have no pending appointments</p>
        <?php } ?>

    </div>