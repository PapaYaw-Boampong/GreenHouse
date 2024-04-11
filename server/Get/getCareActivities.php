<?php
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;

// Initialize response array
$response = array();

// Initialize array to store plant care information
$plantCare = array();

// Check if user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];


if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET['plant_id'])){
        // Prepare SQL statement to select plant care information by user ID
    $sql = "SELECT activity_id, activity_name, custom
    FROM care_activities
    WHERE custom IS NULL OR custom = ?;
    ";

// Prepare the SQL statement
$stmt = $connection->prepare($sql);

// Bind parameters
$stmt->bind_param("i", $_GET['plant_id']);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows > 0) {

    // Fetch data from the result set
    while ($row = $result->fetch_assoc()) {
        // Add each plant care information to the array
        $plantCare[] = $row;
    }

    // Set success response with plant care information data
    $response['success'] = true;
    $response['message'] = "Plant care information retrieved successfully.";
    $response['plantCare'] = $plantCare;
} else {
    // If no results found
    $response['success'] = true;
    $response['message'] = "No plant care information found.";
}

// Close the statement
$stmt->close();
    }else{
        $response['success'] = false;
        $response['message'] = "plant care id not given ";
        $response['plantCare'] = $plantCare;

    }

    
}else{
    // If request method is not GET
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
    $response['plantCare'] = $plantCare;
}




// Encode the response array as JSON and echo it
echo json_encode($response);
