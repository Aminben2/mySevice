<?php
function validateUsername($username)
{

    if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {
        return false;
    }

    $minLength = 3;
    $maxLength = 20;
    $length = strlen($username);
    if ($length < $minLength || $length > $maxLength) {
        return false;
    }

    return true;
}
function validateAddress($address)
{
    $address = trim($address);

    if (empty($address)) {
        return false;
    }

    if (!preg_match('/^[a-zA-Z0-9\s\.,\-]+$/', $address)) {
        return false;
    }

    return true;
}
function validatePassword($password, $confirmPassword)
{
    $password = trim($password);
    $confirmPassword = trim($confirmPassword);

    if (empty($password) || empty($confirmPassword)) {
        return false;
    }

    if ($password !== $confirmPassword) {
        return false;
    }

    return true;
}

function validatePassword1($password)
{
    $password = trim($password);

    if (strlen($password) < 8) {
        return false;
    }


    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    if (!preg_match('/\d/', $password)) {
        return false;
    }

    return true;
}

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
