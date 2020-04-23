<?php

function is_user_LoggedIn()
{
    if (!$_SESSION['loggedIn'] && !empty($_SESSION['loggedIn'])) {
        return true;
    }
    return false;
}

function is_token_set()
{
    return is_token_set_in_get() || is_token_set_in_session();
}

function is_token_set_in_session()
{
    return isset($_SESSION['token']);
}

function is_token_set_in_get()
{
    isset($_SESSION['token']);
}

function findUser()
{
    // check database if user exists
}
