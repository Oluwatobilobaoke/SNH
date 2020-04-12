<?php

// print_r($_POST);

// Collecting the data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$designation = $_POST['designation'];
$department = $_POST['department'];


$errorArray = [];

if ($first_name == "") {
    $errorArray = "First Name cannot be empty";
}

print_r($errorArray);

//saving the data into the database (folder)


// return back to the page, with status message
