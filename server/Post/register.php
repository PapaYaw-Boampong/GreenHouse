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

    // Check if email already exists
    $query_check_email = "SELECT COUNT(*) AS email_count FROM Users WHERE email = ?";
    $stmt_check_email = $connection->prepare($query_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();
    $row_email = $result_check_email->fetch_assoc();

    if ($row_email['email_count'] > 0) {
        // Email already exists, return appropriate response
        $response['success'] = false;
        $response['message'] = "Email already exists.";
    } else {
        // Email does not exist, proceed with registration

        // Encrypt the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the INSERT statement
        $query_insert_user = "INSERT INTO Users (username, email, password_hash, fname, lname, dob, gender, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_user = $connection->prepare($query_insert_user);
        $stmt_insert_user->bind_param("ssssssis", $username, $email, $hashed_password, $firstname, $lastname, $dob, $gender, $pnum);

        // Execute the INSERT query
        if ($stmt_insert_user->execute()) {
            $response['success'] = true;
            $response['message'] = "Registration successful.";
        } else {
            $response['success'] = false;
            $response['message'] = "Cannot register user at the moment.";
        }
    }
} else {
    // Form not submitted
    $response['success'] = false;
    $response['message'] = "Cannot process. " . $_SERVER["REQUEST_METHOD"];
}

// Close the database connection
mysqli_close($connection);

// Output JSON response
echo json_encode($response);
?>