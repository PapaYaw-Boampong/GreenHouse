<?php
// Initialize response array
$response = array();

// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;


// Check if user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the request
    $activity_id = $connection->real_escape_string($_POST['pc-name']);
    $plant_id = $connection->real_escape_string($_POST['plant_id']);

    // Prepare the SELECT statement to check for duplicates
    $query = "SELECT * FROM Plant_Care WHERE activity_id = ? AND plant_id = ?";

    // Prepare the statement
    $stmt = $connection->prepare($query);

    // Bind parameters
    $stmt->bind_param("ii", $activity_id, $plant_id);

    // Execute the query
    $stmt->execute();

    // Store the result
    $stmt->store_result();

    // Check if any rows were returned
    if ($stmt->num_rows > 0) {
        // If a duplicate exists
        $response['success'] = false;
        $response['message'] = "Duplicate record exists.";
    } else {
        // If no duplicate exists, prepare the INSERT statement
        $query = "INSERT INTO plant_care (activity_id, plant_id) VALUES (?, ?)";

        // Prepare the statement
        $stmt = $connection->prepare($query);

        // Bind parameters
        $stmt->bind_param("ii", $activity_id, $plant_id);

        // Execute the query
        if ($stmt->execute()) {
            // If insertion is successful
            $response['success'] = true;
            $response['message'] = "Record inserted successfully.";
        } else {
            // If insertion fails
            $response['success'] = false;
            $response['message'] = "Failed to insert record.";
        }
    }

    // Close the statement
    $stmt->close();
} else {
    // If request method is not POST
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

// Encode the response array as JSON and echo it
echo json_encode($response);
?>
