<?php
// Initialize response array
$response = array();

// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;

if (!checkLogin()){
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    
    echo $response;
    exit;
}


// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the JSON data sent in the request body
    $json_data = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($json_data);

    // Check if plantId is set in the received data
    if (isset($data->task_id)) {
        // Perform the deletion operation using the received plantId
        $task_id= $data->task_id;

        // Prepare and execute the delete query
        $query = "DELETE FROM Tasks WHERE task_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $task_id);

        // Check if the query execution is successful
        if ($stmt->execute()) {
            // Return success response
            $response = array(
                'success' => true,
                'message' => 'Task deleted successfully.'
            );
        } else {
            // Return error response if deletion fails
            $response = array(
                'success' => false,
                'message' => 'Failed to delete Task . Please try again later.'
            );
        }
    } else {
        // Return error response if plantId is not set
        $response = array(
            'success' => false,
            'message' => 'Task ID not provided.'
        );
    }
} else {
    // Return error response if request method is not POST
    $response = array(
        'success' => false,
        'message' => 'Invalid request method.'
    );
}

// Encode the response as JSON and send it
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($connection);
?>
