<?php
include("../dbconnect.php");

session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
}

$id_service = $_POST["id_service"];

try {
    $stmt = $pdo->prepare("DELETE  FROM service WHERE id_service = :id");
    $stmt->bindParam(':id', $id_service);
    $stmt->execute();

    session_start();

    if ($stmt->rowCount() > 0) {
        $_SESSION["msg"] = "Service deleted successfully";
        header("Location: ../services.php");
        exit;
    } else {
        $_SESSION["msg"] = "Failed to delete Service";
        header("Location: ../services.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
}
