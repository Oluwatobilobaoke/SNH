<?php include_once('lib/header.php');
require_once('functions/alert.php');
require_once("functions/redirect.php");




// Start the session
if (isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn'])) {
    // redirect to dashboard
    if ($_SESSION['role'] == "Medical Team(MT)") {
        redirect_to("dashboard.php");
    }
    if ($_SESSION['role'] == "Patient") {
        redirect_to("patientDashboard.php");
    }
    if ($_SESSION['role'] == "Super Admin") {
        redirect_to("adminDashboard.php");
    }
}

?>

<div class="container">
    <div class="row col-6">
        <h1>Log In</h1>
    </div>
    <div class="row col-6">
        <p>
            <?php print_alert();
            ?>
        </p>
        <form method="POST" action="processlogin.php">


            <p>
                <label>Email:</label><br>
                <input value="<?php
                                if (isset($_SESSION['email']) && $_SESSION['email'] != '') {
                                    echo $_SESSION['email'];
                                }

                                ?>" type="email" name="email" placeholder="Please enter email">
            </p>
            <p>
                <label>Password</label><br />
                <input type="password" name="password" placeholder="Password" />
            </p>


            <p>
                <button type="submit">Login</button>
            </p>

        </form>
    </div>

</div>




<?php include_once('lib/footer.php'); ?>