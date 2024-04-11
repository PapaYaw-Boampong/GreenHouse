<?php
// Initialize response array
$response = array();

// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;

if (!checkLogin()){
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    
    echo json_encode($response);
    exit;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the JSON data sent in the request body
    $requestData = json_decode(file_get_contents("php://input"));

    // Check if the request body contains the required data
    if (!isset($requestData->care_Id) || !isset($requestData->custom)) {
        $response['success'] = false;
        $response['message'] = "Care ID or Custom flag is missing in the request body.";
        echo json_encode($response);
        exit;
    }

    // Sanitize and get the care ID and custom flag from the request data
    $careId = mysqli_real_escape_string($connection, $requestData->care_Id);
    $custom = $requestData->custom;

    // Prepare SQL query based on the custom flag
    if ($custom) {
        // Delete from the Plant_Care table
        $sql = "DELETE FROM Plant_Care WHERE activity_id = $careId";
    } else {
        // Delete from the Care_activities table
        $sql = "DELETE FROM Care_activities WHERE activity_id = $careId";
    }

    // Execute the query
    if ($connection->query($sql) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Care item deleted successfully.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error deleting care item: " . $connection->error;
    }
} else {
    // If request method is not POST
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

// Close the connection
$connection->close();

// Encode the response array as JSON and echo it
echo json_encode($response);
?>
