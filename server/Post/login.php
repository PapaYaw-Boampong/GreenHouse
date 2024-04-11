<?php
session_start();

// Include the connection file
include '../settings/connection.php';

global $connection;

// Initialize response array
$response = array();

// Check if login button was clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and store in variables
    $email = $connection->real_escape_string($_POST['email']);
    $password = $connection->real_escape_string($_POST['password']);

    // Write a query to SELECT a record from the people table using the email
    $query = "SELECT * FROM users WHERE email = '$email'";

    // Execute the query using the connection from the connection file
    $result = mysqli_query($connection, $query);

    // Check if any row was returned
    if (mysqli_num_rows($result) == 0) {
        // If no record found provide appropriate response
        $response['success'] = false;
        $response['message'] = "User not found.";
    } else {
        // Fetch the record
        $user = mysqli_fetch_assoc($result);

        // Verify password user provided against database record using password_verify()
        if (!password_verify($password, $user['password_hash'])) {
            // If verification fails provide appropriate response
            $response['success'] = false;
            $response['message'] = "Incorrect password.";
        } else {
            // Get the session ID
            $sessionID = session_id();
            session_regenerate_id(true); 
            // Create a session for user id and role id
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            // Set success to true
            $response['success'] = true;
            $response['message'] = "Login successful.";
            $response['sessionID'] = $sessionID; 
    
        }
    }
} else {
    // If login button was not clicked, provide appropriate message or redirection
    $response['success'] = false;
    $response['message'] = "Invalid request. cannot process ". $_SERVER['REQUEST_METHOD'];
}

// Close the connection
mysqli_close($connection);

// Encode the response array as JSON and echo it
echo json_encode($response);