<?php
session_start();
require_once('functions/alert.php');
require_once('functions/redirect.php');
require_once('functions/token.php');
require_once('functions/user.php');

$userData = json_decode($_SESSION['userObject']);
$errorCount = 0;

$_POST['name'] !== '' ? $name = check_input($_POST['name'])  : $errorCount++;
$_POST['email'] !== '' ? $email = check_input($_POST['email'])  : $errorCount++;
$_POST['amount'] !== '' ? $amount = check_input($_POST['amount'])  : $errorCount++;
