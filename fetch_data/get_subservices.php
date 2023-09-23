<?php
require("../dbconnect.php");
// Retrieve the selected service ID from the AJAX request
$service_id = $_GET['service_id'];

// Perform your database query to fetch the sub-services based on the service ID
// Make sure to sanitize and validate the input parameters

// Example code to fetch sub-services from the database using PDO
// Replace the database credentials and table/column names with your own


try {
    // Create a new PDO instance

    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT id_service , name_service  FROM service WHERE parent_service = :service_id");

    // Bind the parameter
    $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Fetch all the rows as an associative array
    $subServices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the connection
    $connection = null;

    // Return the sub-services as a JSON response
    header('Content-Type: application/json');
    echo json_encode($subServices);
} catch (PDOException $e) {
    // Handle any errors that occurred during the database connection or query
    echo "Error: " . $e->getMessage();
}
