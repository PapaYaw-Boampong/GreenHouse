<?php
// Initialize response array
$response = array();

// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;

if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";

    echo json_encode($response);
    exit();
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Perform logout actions here, such as destroying the session

    // Close the database connection if it's not already closed
    if ($connection) {
        $connection->close();
    }
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();


    // Set success response
    $response['success'] = true;
    $response['message'] = "Logout successful.";
} else {
    // If request method is not POST
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

// Encode the response array as JSON and echo it
echo json_encode($response);
?>
