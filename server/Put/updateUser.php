<?php
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;

// Initialize response array
$response = array();
// Initialize array to store schedules
$schedules = array();
// Check if user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

// Initialize response array
$response = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Collect form data and assign each to a variable
    $userId = $_SESSION['user_id']; // Assuming you have the user ID in session
    $firstname = $connection->real_escape_string($_POST['firstName']);
    $lastname = $connection->real_escape_string($_POST['lastName']);
    $email = $connection->real_escape_string($_POST['email']);
    $password = $connection->real_escape_string($_POST['password']);
    $gender = $connection->real_escape_string($_POST['gender']);
    $dob = $connection->real_escape_string($_POST['dob']);
    $pnum = $connection->real_escape_string($_POST['pnum']);
    $username = $connection->real_escape_string($_POST['username']);
    $bio = $connection->real_escape_string($_POST['bio-in']);

    // Encrypt the password if it's provided
    if ($password == "") {
        // Prepare the UPDATE statement
        $query = "UPDATE Users SET username=?, email=?, fname=?, lname=?, dob=?, gender=?, phone=?, bio=? WHERE user_id=?";

        // Prepare the statement
        $stmt = $connection->prepare($query);

        // Bind parameters
        $stmt->bind_param("ssssssisi", $username, $email, $firstname, $lastname, $dob, $gender, $pnum, $bio, $userId);
    } else {
        $hashed_password = "";
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }

        // Prepare the UPDATE statement
        $query = "UPDATE Users SET username=?, email=?, password_hash=?, fname=?, lname=?, dob=?, gender=?, phone=?, bio=? WHERE user_id=?";

        // Prepare the statement
        $stmt = $connection->prepare($query);

        // Bind parameters
        $stmt->bind_param("sssssssisi", $username, $email, $hashed_password, $firstname, $lastname, $dob, $gender, $pnum, $bio, $userId);
    }


    // Execute the query using the connection from the connection file
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Profile updated successfully.";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to update profile.";
    }
} else {
    // Form not submitted
    $response['success'] = false;
    $response['message'] = "Form not submitted.";
}

// Close the statement
$stmt->close();

// Close the connection
mysqli_close($connection);

// Encode the response array as JSON and echo it
echo json_encode($response);

?>