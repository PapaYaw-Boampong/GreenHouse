<?php
// Enable error reporting
error_reporting(E_ALL);

// Display errors
ini_set('display_errors', 1);
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
    exit;
}

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    // Check if user ID is set in the session
    if (isset($_SESSION['user_id'])) {
        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];

        // Prepare the SQL query to select user data
        $sql = "SELECT * FROM Users WHERE user_id = $user_id";

        // Execute the query
        $result = $connection->query($sql);

        // Check if the query was successful
        if ($result) {
            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Fetch the user data
                $user = $result->fetch_assoc();

                // Set success response with user data
                $response['success'] = true;
                $response['message'] = "User retrieved successfully.";
                $response['user'] = $user;
            } else {
                // No user found
                $response['success'] = false;
                $response['message'] = "User not found.";
            }
        } else {
            // Query execution failed
            $response['success'] = false;
            $response['message'] = "Error executing SQL query.";
        }
    } else {
        // User ID not set in session
        $response['success'] = false;
        $response['message'] = "User ID not found in session.";
    }
} else {
    // If request method is not GET
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

// Close the connection
$connection->close();

// Encode the response array as JSON and echo it
echo json_encode($response);
?>