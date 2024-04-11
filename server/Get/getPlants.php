<?php
include '../settings/connection.php';
include '../settings/core.php';

$response = array();

$plants = array();
 

global $connection;

if (!checkLogin()){
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    if(isset($_GET['plant_id'])){
        $sql = "SELECT * FROM Plants WHERE plant_id = ".$_GET['plant_id'];
    }else{
        $sql = "SELECT plant_id, name, species FROM Plants WHERE user_id = $user_id";

    }

    // Execute the query
    $result = $connection->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
       

        // Fetch data from the result set
        while ($row = $result->fetch_assoc()) {
            // Add each plant to the array
            $plants[] = $row;
        }

        // Set success response with plants data
        $response['success'] = true;
        $response['message'] = "Plants retrieved successfully.";
        $response['plants'] = $plants;
    } else {
        // If no results found
        $response['success'] = true;
        $response['message'] = "No plants found.";
        $response['plants'] = $plants;
    }
} else {
    // If request method is not GET
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
    $response['plants'] = $plants;
}

// Close the connection
$connection->close();

// Encode the response array as JSON and echo it
echo json_encode($response);
?>