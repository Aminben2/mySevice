<?php

$id = $_GET["id_category"];
if (isset($_GET["reset"]) && $_GET["reset"] == "true") {
    unset($_POST);
    header("location: services.php?id_category=$id");
    exit;
}
