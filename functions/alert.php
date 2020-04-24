<?php
require_once('redirect.php');

function print_alert()
{
    $types = ['message', 'info', 'error'];
    $colors = ['success', 'info', 'danger'];
    for ($i = 0; $i < count($types); $i++) {
        if (isset($_SESSION[$types[$i]]) && $_SESSION[$types[$i]] != '') {

            echo "<span style='color:" . $colors[$i] . "'>" . $_SESSION[$types[$i]] . "</span>";
        }
    }
}

function set_alert($type = "message", $content = "")
{
    switch ($type) {
        case "message":
            $_SESSION['message'] = $content;
            break;
        case "error":
            $_SESSION['error'] = $content;
            break;
        case "info":
            $_SESSION['info'] = $content;
            break;
        default:
            $_SESSION['message'] = $content;
    }
}

function check_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
