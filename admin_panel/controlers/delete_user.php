<?php
include("../dbconnect.php");

session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
}

$id_user = $_POST["id_user"];

$stmt = $pdo->prepare("DELETE  FROM user WHERE id_user = :id");
$stmt->bindParam(':id', $id_user);
$stmt->execute();



if ($stmt->rowCount() > 0) {

    $_SESSION["msg"] = "User deleted successfully";
    header("Location: ../users.php");
    exit;
} else {
    $_SESSION["msg"] = "Failed to delete user";
    header("Location: ../users.php");
    exit;
}

