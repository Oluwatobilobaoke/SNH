<?php
include_once('lib/header.php');
if (!isset($_SESSION['loggedIn'])) {
    // redirect to dashboard
    header("Location: login.php");
}

$userData = json_decode($_SESSION['userObject']);
?>

<div class="container">
    <div id="headings">
        <h3>Patient Dashboard</h3>
        LoggedIn User ID: <?php echo $_SESSION['loggedIn'] ?> <br>
        Welcome, <?php echo $_SESSION['email'] ?>!, You are Logged in as (<?php echo $_SESSION['role'] ?>), and your User ID is <?php echo $_SESSION['loggedIn'] ?>.
    </div>




    <br>
    <br>
    <a class="btn btn-bg btn-info" href="paybill.php">Pay Bill</a> | | |
    <a class="btn btn-bg btn-info" href="bookappointment.php">Book Appointment</a>


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