<?php
function print_alert()
{
    $types = ['message', 'info', 'error'];
    $colors = ['green', 'grey', 'red'];
    for ($i = 0; $i < count($types); $i++) {
        if (isset($_SESSION[$types[$i]]) && $_SESSION[$types[$i]] != '') {

            echo "<span style='color:" . $colors[$i] . "'>" . $_SESSION[$types[$i]] . "</span>";
            if (!isset($_SESSION['LoggedIn'])) {
                session_destroy();
            } else {
                unset($_SESSION[$types[$i]]);
            }
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
