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
        <a class="btn btn-outline-danger" href="dashboard.php" style="margin: 20px">Back</a>

        <?php
        $rows = getPaidBills();
        if ($rows) {

        ?>
            <table class="table table-bordered">
                <caption>
                    Bills Payment Table</caption>
                <thead class="thead-dark ">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Currency</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $rows; ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>You have no pending payments</p>
        <?php } ?>

    </div>