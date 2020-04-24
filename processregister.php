<?php session_start();
require_once("functions/alert.php");
require_once('functions/user.php');
// print_r($_POST);

// Collecting the data

$errorCount = 0;

$first_name = $_POST['first_name'] != "" ? $_POST['first_name'] : $errorCount++;
$last_name = $_POST['last_name'] != "" ? $_POST['last_name'] : $errorCount++;
$email = $_POST['email'] != "" ? $_POST['email'] : $errorCount++;
$password = $_POST['password'] != "" ? $_POST['password'] : $errorCount++;
$gender = $_POST['gender'] != "" ? $_POST['gender'] : $errorCount++;
$designation = $_POST['designation'] != "" ? $_POST['designation'] : $errorCount++;
$department = $_POST['department'] != "" ? $_POST['department'] : $errorCount++;

// $_SESSION['$first_name'] = $first_name;
// $_SESSION['$last_name'] = $last_name;
// $_SESSION['$email'] = $email;
// $_SESSION['$gender'] = $gender;
// $_SESSION['$designation'] = $designation;
// $_SESSION['$department'] = $department;

$fnerrorempty = $fnerrorlen = $fnerrorstring = "";
$lnerrorempty = $lnerrorlen = $lnerrorlenstr = "";
$emailerrempty = $emailerrlen = $emailerrfmt = "";
$depterr = $designitureerr = $gendererr = "";

if ($first_name == " ") {
    $fnerrorempty = "Firstname cannot be empty";
    $errorCount++;
} elseif (!empty($first_name) && strlen($first_name) < 3) {
    $fnerrorlen = "Firstname must be greater than 2";
    $errorCount++;
} else
    //if(!empty($first_name) && is_numeric($first_name) && ctype_alnum($first_name)){
    if (!empty($first_name) && preg_match("/^[a-zA-Z]+$/", $first_name) === 0) {
        $fnerrorstring = "Firstname requires letters  alone";
        $errorCount++;
    } else {
        $_SESSION['first_name'] = $first_name;
    }

if ($last_name == " ") {
    $lnerrorempty = "lasttname cannot be empty";
    $errorCount++;
} elseif (!empty($last_name) && strlen($last_name) < 3) {
    $lnerrorlen = "lasttname must be greater than 2";
    $errorCount++;
} else
    //if(!empty($last_name) && is_numeric($last_name)  && ctype_alnum($first_name)){
    if (!empty($last_name) && preg_match("/^[a-zA-Z]+$/", $last_name) === 0) {
        $lnerrorlenstr = "lasttname requires string alone";
        $errorCount++;
    } else {
        $_SESSION['last_name'] = $last_name;
    }

if ($email == "") {
    $emailerrempty = "Email cannot be empty";
    $errorCount++;
} elseif (!empty($email) && strlen($email) < 5) {
    $emailerrlen = "Email must be greater than 5";
    $errorCount++;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailerrfmt = "Invalid email format";
    $errorCount++;
} else {
    $_SESSION['email'] = $email;
}

if (empty($password)) {
    $passworderr = "Password cannot be empty";
    $errorCount++;
}

if (empty($gender)) {
    $gendererr = "Select a gender";
    $errorCount++;
} else {
    $_SESSION['gender'] = $gender;
}

if (empty($designation)) {
    $designitureerr = "Select a designation";
    $errorCount++;
} else {
    $_SESSION['designation'] = $designation;
}

if (empty($department)) {
    $depterr = "Department cannot be empty";
    $errorCount++;
} else {
    $_SESSION['department'] = $department;
}


if ($errorCount > 0) {
    // Display proper messages to the user
    //Give more accurate feedback to the user.
    $_SESSION["fnerrorempty"] = $fnerrorempty;
    $_SESSION["fnerrorlen"] = $fnerrorlen;
    $_SESSION["fnerrorstring"] = $fnerrorstring;

    $_SESSION["lnerrorempty"] = $lnerrorempty;
    $_SESSION["lnerrorlen"] = $lnerrorlen;
    $_SESSION["lnerrorlenstr"] = $lnerrorlenstr;

    $_SESSION["emailerrempty"] = $emailerrempty;
    $_SESSION["emailerrlen"] = $emailerrlen;
    $_SESSION["emailerrfmt"] = $emailerrfmt;

    $_SESSION["passworderr"] = $passworderr;

    $_SESSION["gendererr"] = $gendererr;

    $_SESSION["designitureerr"] = $designitureerr;

    $_SESSION["depterr"] = $depterr;

    // redirect back and display error
    header("Location: register.php");
} else {

    date_default_timezone_set("Africa/Lagos");
    $dateData = date('d M Y h:i:sa');
    // Count all users
    // Assign Id to eachc user,
    // *** Count All the users,
    //save in the database

    // $userExists = findUser($email);
    $allUsers = scandir("db/users/"); //return @array (2 filled)


    $countAllUsers = count($allUsers);
    $newUserId = ($countAllUsers - 1);
    // defining UserObject to be saved 
    $userObject = [
        'id' => $newUserId,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT), //password hashing
        'gender' => $gender,
        'designation' => $designation,
        'department' => $department,
        "dateRegistered" => $dateData
    ];

    // Check if user already exists
    //scan db array ad check if email already exists
    $userExists = findUser($email);


    if ($userExists) {
        set_alert('error', "Registration Failed, User already exits");
        redirect_to("register.php");
        die();
    }
    // Save to database
    saveUser($userObject);
    set_alert("message", "Registration Successful, you can now login " . $first_name);
    redirect_to("login.php");
}



// $first_name = $_POST['first_name'];
// $last_name = $_POST['last_name'];
// $email = $_POST['email'];
// $password = $_POST['password'];
// $gender = $_POST['gender'];
// $designation = $_POST['designation'];
// $department = $_POST['department'];

/* Another method of validation
// $errorArray = [];

// if ($first_name == "") {
//     $errorArray = "First Name cannot be empty";
// }
// if ($last_name == "") {
//     $errorArray = "Last Name cannot be empty";
// }
// if ($email == "") {
//     $errorArray = "email cannot be empty";
// }

// print_r($errorArray);
*/

//saving the data into the database (folder)


// return back to the page, with status message
