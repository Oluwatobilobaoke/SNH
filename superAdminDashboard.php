<?php
include_once('lib/header.php');
if (!isset($_SESSION['loggedIn'])) {
    // redirect to dashboard
    header("Location: login.php");
}

$userData = json_decode($_SESSION['userObject']);
?>

<h3>SuperAdmin Dashboard</h3>

LoggedIn User ID: <?php echo $_SESSION['loggedIn'] ?> <br>
Welcome, <?php echo $_SESSION['email'] ?>!, You are Logged in as Super Admin, and your User ID is <?php echo $_SESSION['loggedIn'] ?>.

<p>Date of Registration : <?php echo  $userData->dateRegistered  ?></p>
<p>Last Login : <?php
                if (isset($lastLogIn)) {
                    echo  $lastLogIn;
                } else {
                    echo $userData->dateRegistered;
                }

                ?></p>

<p>Click on the button to create user</p>
<p>
    <a class="" href="#form">Create New User</a>
</p>

<p>Create A New User</p>
<form method="POST" action="processcreate.php">
    <h1>Register New User</h1>
    <p>
        <?php
        if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
            echo "<p class='error'>" . $_SESSION['error'] . "</p><br>";
            session_destroy();
            // session_unset();
        }
        if (isset($_SESSION['fnerrorempty']) && !empty($_SESSION['fnerrorempty'])) {
            echo "<p class='error'>" . $_SESSION['fnerrorempty'] . "</p>";

            session_unset();
            //session_destroy();
        }
        if (isset($_SESSION['fnerrorlen']) && !empty($_SESSION['fnerrorlen'])) {
            echo "<p class='error'>" . $_SESSION['fnerrorlen'] . "</p>";

            session_unset();
            //session_destroy();
        }
        if (isset($_SESSION['fnerrorstring']) && !empty($_SESSION['fnerrorstring'])) {
            echo "<p class='error'>" . $_SESSION['fnerrorstring'] . "</p>";

            session_unset();
            //session_destroy();
        }
        if (isset($_SESSION['lnerrorempty']) && !empty($_SESSION['lnerrorempty'])) {
            echo "<p class='error'>" . $_SESSION['lnerrorempty'] . "</p>";

            //session_unset();
            session_destroy();
        }
        if (isset($_SESSION['lnerrorlen']) && !empty($_SESSION['lnerrorlen'])) {
            echo "<p class='error'>" . $_SESSION['lnerrorlen'] . "</p>";

            //session_unset();
            // session_destroy();
        }
        if (isset($_SESSION['lnerrorlenstr']) && !empty($_SESSION['lnerrorlenstr'])) {
            echo "<p class='error'>" . $_SESSION['lnerrorlenstr'] . "</p>";

            //session_unset();
            session_destroy();
        }
        if (isset($_SESSION['passworderr']) && !empty($_SESSION['passworderr'])) {
            echo "<p class='error'>" . $_SESSION['passworderr'] . "</p>";

            //session_unset();
            session_destroy();
        }
        if (isset($_SESSION['gendererr']) && !empty($_SESSION['gendererr'])) {
            echo "<p class='error'>" . $_SESSION['gendererr'] . "</p>";

            //session_unset();
            session_destroy();
        }
        if (isset($_SESSION['designitureerr']) && !empty($_SESSION['designitureerr'])) {
            echo "<p class='error'>" . $_SESSION['designitureerr'] . "</p>";

            //session_unset();
            session_destroy();
        }
        if (isset($_SESSION['depterr']) && !empty($_SESSION['depterr'])) {
            echo "<p class='error'>" . $_SESSION['depterr'] . "</p>";

            //session_unset();
            session_destroy();
        }

        ?>
    </p>
    <p>
        <label>First Name</label><br />
        <input <?php
                if (isset($_SESSION['first_name'])) {
                    echo "value=" . $_SESSION['first_name'];
                }
                ?> type="text" name="first_name" placeholder="First Name" />
    </p>
    <p>
        <label>Last Name</label><br />
        <input <?php
                if (isset($_SESSION['last_name'])) {
                    echo "value=" . $_SESSION['last_name'];
                }
                ?> type="text" name="last_name" placeholder="Last Name" />
    </p>
    <p>
        <label>Email</label><br />
        <input <?php
                if (isset($_SESSION['email'])) {
                    echo "value=" . $_SESSION['email'];
                }
                ?> type="text" name="email" placeholder="Email" />
    </p>

    <p>
        <label>Password</label><br />
        <input type="password" name="password" placeholder="Password" />
    </p>
    <p>
        <label>Gender</label><br />
        <select name="gender">
            <option value="">Select One</option>
            <option <?php
                    if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female') {
                        echo "selected";
                    }
                    ?>>Female</option>
            <option <?php
                    if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male') {
                        echo "selected";
                    }
                    ?>>Male</option>
        </select>
    </p>

    <p>
        <label>Designation</label><br />
        <select name="designation">

            <option value="">Select One</option>
            <option <?php
                    if (isset($_SESSION['designation']) && $_SESSION['designation'] == 'Medical Team (MT)') {
                        echo "selected";
                    }
                    ?>>Medical Team (MT)</option>
            <option <?php
                    if (isset($_SESSION['designation']) && $_SESSION['designation'] == 'Patient') {
                        echo "selected";
                    }
                    ?>>Patient</option>
        </select>
    </p>
    <p>
        <label>Department</label><br />
        <input <?php
                if (isset($_SESSION['department'])) {
                    echo "value=" . $_SESSION['department'];
                }
                ?> type="text" name="department" placeholder="Department" />

    </p>
    <p>
        <button type="submit">Register</button>
    </p>
</form>

<?php include_once('lib/footer.php'); ?>