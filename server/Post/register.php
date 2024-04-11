<?php
// Include the connection file
include '../settings/connection.php';

// Initialize response array
$response = array();

global $connection;


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Collect form data and assign each to a variable
    $firstname = $connection->real_escape_string($_POST['firstName']);
    $lastname = $connection->real_escape_string($_POST['lastName']);
    $email = $connection->real_escape_string($_POST['email']);
    $password = $connection->real_escape_string($_POST['confirm-password']);
    $gender = $connection->real_escape_string($_POST['gender']);
    $dob = $connection->real_escape_string($_POST['dob']);
    $pnum = $connection->real_escape_string($_POST['pnum']);
    $username = $connection->real_escape_string($_POST['username']);


    // Encrypt the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the INSERT statement
    $query = "INSERT INTO Users (username, email, password_hash, fname, lname, dob, gender, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $connection->prepare($query);

    // Bind parameters
    $stmt->bind_param("ssssssis", $username, $email, $hashed_password, $firstname, $lastname,$dob, $gender, $pnum, );


    // Execute the query using the connection from the connection file
    if ($stmt->execute()) {

        $response['success'] = true;
        $response['message'] = "Register Successfull";
    } else {

        $response['success'] = false;
        $response['message'] = "Cannot Register User at the moment.";
    }
} else {
    // Redirect to register_view page if form is not submitted
    $response['success'] = false;
    $response['message'] = "Cannot process. " . $_SERVER["REQUEST_METHOD"];
}

echo json_encode($response);

// Close the connection
mysqli_close($connection);
