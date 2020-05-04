<?php
include_once('lib/header.php');
require_once('functions/alert.php');
if (!isset($_SESSION['loggedIn']) || $_SESSION['role'] !== "Medical Team (MT)") {
    // redirect to dashboard
    header("Location: login.php");
}
$userData = json_decode($_SESSION['userObject']);
?>


<div id="container">
    <div id="headings">
        <h3>Medical Team Dashboard</h3>

        LoggedIn User ID: <?php echo $_SESSION['loggedIn'] ?> <br>
        Welcome, <?php echo $_SESSION['email'] ?>!, You are Logged in as (<?php echo $_SESSION['role'] ?>), and your User ID is <?php echo $_SESSION['loggedIn'] ?>

    </div>


    <ul class="innerlinks">
        <li><a class="btn-dark btn-lg btn-outline-secondary" href="appointmentbookingstable.php" style="margin: 20px">View Appointments</a>
        <li><a class="btn-info btn-lg" href="billpaymentstable.php">View Paid Bills</a></li>
    </ul>
    <br>

    <br>

    <br>
    <hr>

    <div class="details">
        <p>Date of Registration : <?php echo  $userData->dateRegistered  ?></p>
        <p>Last Login : <?php
                        if (isset($lastLogIn)) {
                            echo  $lastLogIn;
                        } else {
                            echo $userData->dateRegistered;
                        }

                        ?></p>
        <p>Department : <?php echo $userData->department  ?></p>
    </div>
</div>




<?php include_once('lib/footer.php'); ?>