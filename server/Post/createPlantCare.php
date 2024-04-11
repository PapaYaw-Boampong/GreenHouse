<?php
// Initialize response array
$response = array();
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';
// Check if user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

// Check if form data was sent in the request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data and store in variables
    $activity_name = $_POST['pc-name'];
    $custom = $_POST['plant_id'];
    $description = $_POST['pc-description'];

    // Prepare INSERT statement
    $query = "INSERT INTO Care_activities (activity_name, custom, description) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);

    // Bind parameters to prepared statement
    mysqli_stmt_bind_param($stmt, "sis", $activity_name, $custom, $description);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // If query executed successfully, provide success response
        $response['success'] = true;
        $response['message'] = "Care activity added successfully.";
    } else {
        // If query failed, provide error response
        $response['success'] = false;
        $response['message'] = "Failed to add care activity: " . mysqli_error($connection);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // If form data is not sent via POST, provide appropriate message
    $response['success'] = false;
    $response['message'] = "Invalid request method. POST method expected.";
}

// Encode the response array as JSON and echo it
echo json_encode($response);
?>