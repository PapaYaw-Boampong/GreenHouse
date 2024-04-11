<?php
// Enable error reporting
error_reporting(E_ALL);

// Display errors
ini_set('display_errors', 1);
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;

// Initialize response array
$response = array();

// Check if user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $plant_id = $_POST['plant_id'];
    // Collect form data and assign each to a variable
    $plantname = $connection->real_escape_string($_POST['plantname']);
    $plantspecies = $connection->real_escape_string($_POST['plantspecies']);
    $plantdescription = $connection->real_escape_string($_POST['plantdescription']);
    $plantnotes = $connection->real_escape_string($_POST['plantnotes']);

    // Prepare the UPDATE statement
    $query = "UPDATE Plants SET species=?, description=?, personal_notes=?, name=? WHERE plant_id=?";

    // Prepare the statement
    $stmt = $connection->prepare($query);

    // Bind parameters
    $stmt->bind_param("ssssi", $plantspecies, $plantdescription, $plantnotes, $plantname, $plant_id);

    // Execute the query using the connection from the connection file
    if ($stmt->execute()) {

        $response['success'] = true;
        $response['message'] = "Plant updated successfully.";
    } else {

        $response['success'] = false;
        $response['message'] = "Failed to update plant.";
    }
} else {
    // Redirect or show an error message if form is not submitted
    $response['success'] = false;
    $response['message'] = "Server Request Error.";
}

// Encode the response array as JSON and echo it
echo json_encode($response);

// Close the connection
mysqli_close($connection);
?>