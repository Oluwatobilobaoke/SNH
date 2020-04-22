<?php include_once('lib/header.php'); ?>
<h3>Forgot Password</h3>
<p>KIndly Provide the email address associated with your account</p>
<form action="processForgot.php" method="POST">
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
        <input <?php
                if (isset(($_SESSION["email"]))) {
                    echo "value=" . $_SESSION['email'];
                }
                ?> type="text" name="email" placeholder="Enter Email" />
    </p>
    <p>
        <button type="submit">Send Reset Code</button>
    </p>

</form>
<?php include_once('lib/footer.php'); ?>