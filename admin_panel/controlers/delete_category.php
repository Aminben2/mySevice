<?php
include("../dbconnect.php");
session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
}


$id_category = $_POST["id_category"];

try {
    $stmt = $pdo->prepare("DELETE  FROM category WHERE id_category = :id");
    $stmt->bindParam(':id', $id_category);
    $stmt->execute();


    if ($stmt->rowCount() > 0) {

        $_SESSION["msg"] = "Category deleted successfully";
        header("Location: ../categories.php");
        exit;
    } else {
        $_SESSION["msg"] = "Failed to delete Category";
        header("Location: ../categories.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
}
