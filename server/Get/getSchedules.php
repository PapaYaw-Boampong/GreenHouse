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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Prepare SQL statement to select schedules by user ID
    $sql = "SELECT * FROM schedule";

    // Prepare the SQL statement
    $stmt = $connection->prepare($sql);


    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any results
    if ($result->num_rows > 0) {

        // Fetch data from the result set
        while ($row = $result->fetch_assoc()) {
            // Add each schedule to the array
            $schedules[] = $row;
        }

        // Set success response with schedules data
        $response['success'] = true;
        $response['message'] = "Schedules retrieved successfully.";
        $response['schedules'] = $schedules;
    } else {
        // If no results found
        $response['success'] = True;
        $response['message'] = "No schedules found.";
        $response['schedules'] = $schedules;
    }

    // Close the statement
    $stmt->close();
}else{
    // If no results found
    $response['success'] = false;
    $response['message'] = "Cannot Process request ".$_SERVER["REQUEST_METHOD"] ;
    $response['schedules'] = $schedules;
}


// Encode the response array as JSON and echo it
echo json_encode($response);
