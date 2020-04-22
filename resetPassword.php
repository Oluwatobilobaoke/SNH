<?php include_once('lib/header.php'); ?>
<h3>Reset Password</h3>
<p>Reset password associated with your account : [email] </p>
<form action="process_Reset_password.php" method="POST">
    <p>
        <?php
        if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
            echo "<span style'color: red'>" . $_SESSION["error"] . "</span>";
            session_destroy();
        }
        ?>
    </p>
    <p>
        <label for="Email"></label><br>
        <input readonly value="[email]" type="text" name="email" placeholder="Enter Email" />
    </p>
    <label>Enter New Password</label><br />
    <input type="password" name="password" placeholder="Password" />
    </p>
    <p>
        <button type="submit">Reset Password</button>
    </p>

</form>
<?php include_once('lib/footer.php'); ?>