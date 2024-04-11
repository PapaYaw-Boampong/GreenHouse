<?php
// Initialize response array
$response = array();
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

// Initialize response array
$response = array();

if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo $response;
}

global $connection;

// Check if JSON data was sent in the request
$jsonData = json_decode(file_get_contents("php://input"), true);

// Check if JSON data is not empty
if (!empty($jsonData)) {
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Collect JSON data and store in variables
        $plantName = $jsonData['plantName'];
        $plantSpecies = $jsonData['plantSpecies'];
        $plantDescription = $jsonData['plantDescription'];
        $plantNotes = $jsonData['plantNotes'];

        // Prepare INSERT statement
        $query = "INSERT INTO Plants (user_id, name, species, description, personal_notes) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);

        // Bind parameters to prepared statement
        mysqli_stmt_bind_param($stmt, "issss", $_SESSION['user_id'], $plantName, $plantSpecies, $plantDescription, $plantNotes);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // If query executed successfully, provide success response
            $response['success'] = true;
            $response['message'] = "Plant added successfully.";
        } else {
            // If query failed, provide error response
            $response['success'] = false;
            $response['message'] = "Failed to add plant: " . mysqli_error($connection);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // If JSON data is empty, provide appropriate message or redirection
        $response['success'] = false;
        $response['message'] = "Invalid request. Cannot process ".$_SERVER["REQUEST_METHOD"];
    }
} else {
    // If JSON data is empty, provide appropriate message or redirection
    $response['success'] = false;
    $response['message'] = "Invalid request. JSON data not provided.";
}

// Close the connection
mysqli_close($connection);

// Encode the response array as JSON and echo it
echo json_encode($response);
?>