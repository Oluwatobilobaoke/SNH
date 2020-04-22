<?php include_once('lib/header.php');
// Start the session
if (isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn'])) {
    // redirect to dashboard
    if ($_SESSION['role'] == "Medical Team(MT)") {
        header("location: dashboard.php");
    }
    if ($_SESSION['role'] == "Patient") {
        header("location: patientDashboard.php");
    }
    if ($_SESSION['role'] == "Super Admin") {
        header("location: adminDashboard.php");
    }
}

?>
<h1>Log In</h1>
<p>
    <?php
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo "<span style'color: green'>" . $_SESSION["message"] . "</span>";
        session_destroy();
    }
    ?>
</p>
<form method="POST" action="processlogin.php">
    <p>
        <?php
        if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
            echo "<span style'color: red'>" . $_SESSION["error"] . "</span>";
            session_destroy();
        }
        ?>
    </p>

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

<?php include_once('lib/footer.php'); ?>