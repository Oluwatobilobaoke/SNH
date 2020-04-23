<?php include_once('lib/header.php');
require_once('functions/alert.php');
require_once('functions/user.php');

// check if token is set
if (!is_user_LoggedIn() && is_token_set()) {
    $_SESSION["error"] = "You are not authorized to view that page ";
    header("Location: login.php");
}

// check token matches set email in iur database


?>
<h3>Reset Password</h3>
<p>Reset password associated with your account</p>
<form action="processreset.php" method="POST">
    <p>
        <?php error();
        message();
        ?>
    </p>
    <?php if (!is_user_LoggedIn()) { ?>

        <input <?php if (is_token_set_in_session()) {
                    echo "value='" . $_SESSION['token'] . "'";
                } else {
                    echo "value='" . $_GET['token'] . "'";
                }

                ?> type="hidden" name="token" />
    <?php } ?>


    <p>
        <label for="Email"></label><br>
        <input type="text" name="email" placeholder="Enter Email" />
    </p>
    <label>Enter New Password</label><br />
    <input type="password" name="password" placeholder="Password" />
    </p>
    <p>
        <button type="submit">Reset Password</button>
    </p>

</form>
<?php include_once('lib/footer.php'); ?>