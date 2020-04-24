<?php

include_once('lib/header.php');
require_once('functions/alert.php');
require_once('functions/tables.php');


if (!isset($_SESSION['loggedIn']) || $_SESSION['role'] !== "Super Admin") {
    set_alert('error', "You have not login");
    header("location:login.php");
}

$userData = json_decode($_SESSION['userObject']);
$table = $_GET['table'];
?>


<section>
    <div id="table">
        <a class="btn btn-outline-danger" href="superAdminDashboard.php" style="margin: 20px"> Back</a>
        <?php

        $rowArry = getAllUsers();
        ?>
        <table class="table table-bordered">
            <caption>
                <?php
                echo $table;
                ?> Table </caption>
            <thead class="thead-dark ">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Department</th>
                    <th scope="col">Date of Registration</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $rowArry[$table]; ?>
            </tbody>
        </table>
    </div>
</section>