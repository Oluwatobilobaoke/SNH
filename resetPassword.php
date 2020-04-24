<?php include_once('lib/header.php');
require_once('functions/alert.php');
require_once("functions/redirect.php");
require_once('functions/user.php');

// check if token is set
if (!is_user_loggedIn() && !is_token_set()) {
    print_alert("error", "You are not authorized to be here Get Out");
    redirect_to("login.php");
}

// check token matches set email in iur database


?>
<h3>Reset Password</h3>
<p>Reset password associated with your account</p>
<form action="processreset.php" method="POST">
    <p>
        <?php
        print_alert();
        ?>
    </p>
    <?php if (!is_user_loggedIn()) { ?>
        <input <?php
                if (is_token_set_in_session()) {
                    echo "value='" . $_SESSION['token'] . "'";
                } else {
                    echo "value='" . $_GET['token'] . "'";
                }
                ?> type="hidden" name="token" />
    <?php } ?>


    <p>
        <label>Email:</label><br>
        <input <?php
                if (isset($_SESSION['email'])) {
                    echo "value=" . $_SESSION['email'];
                }
                ?> type="email" name="email" placeholder="Please enter email">
    </p>
    <label>Enter New Password</label><br />
    <input type="password" name="password" placeholder="Password" />
    </p>
    <p>
        <button type="submit">Reset Password</button>
    </p>

</form>
<?php include_once('lib/footer.php'); ?>