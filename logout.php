<?php
session_start();
if (isset($_SESSION) && !empty($_SESSION)) {
    session_unset();
    session_destroy();
    session_gc();
    header("location: login.php");
    exit;
}
