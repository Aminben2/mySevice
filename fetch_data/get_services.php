<?php
require("../dbconnect.php");
$category_id = $_GET['category_id'];

try {

    $stmt = $connection->prepare("SELECT id_service, name_service FROM service WHERE id_category = :category_id");

    // Bind the parameter
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

    $stmt->execute();

    // Fetch all the rows as an associative array
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the connection
    $connection = null;

    // Return the services as a JSON response
    header('Content-Type: application/json');
    echo json_encode($services);
} catch (PDOException $e) {
    // Handle any errors that occurred during the database connection or query
    echo "Error: " . $e->getMessage();
}
