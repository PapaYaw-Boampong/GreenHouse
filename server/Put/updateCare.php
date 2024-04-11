<?php
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
    if (isset($_POST['care_Id'])){
        $care_id = $_POST['care_Id'];
    // Collect form data and assign each to a variable
    $carename = $connection->real_escape_string($_POST['pc-name']);
    $caredescription = $connection->real_escape_string($_POST['pc-description']);


    // Prepare the UPDATE statement
    $query = "UPDATE care_activities SET activity_name=?, description=?  WHERE activity_id=?";

    // Prepare the statement
    $stmt = $connection->prepare($query);

    // Bind parameters
    $stmt->bind_param("ssi", $carename, $caredescription, $care_id);

    // Execute the query using the connection from the connection file
    if ($stmt->execute()) {

        $response['success'] = true;
        $response['message'] = "Plant updated successfully.";
    } else {

        $response['success'] = false;
        $response['message'] = "Failed to update plant.";
    }
    }else{
        $response['success'] = false;
        $response['message'] = "Care Id not included";
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
