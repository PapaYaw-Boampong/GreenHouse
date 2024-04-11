<?php
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

$response = array();
global $connection;


// Check if user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

// Check if the request method is PUT
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Check if the data is valid
    if (isset($_POST["task_Id"]) && isset($_POST["task-sch"])) {
        // Extract the task ID and schedule from the data
        $taskId = $_POST['task_Id'];
        $schedule = $_POST['task-sch'];

        // Prepare the SQL statement to update the task
        $sql = "UPDATE Tasks SET schedule_id = ? WHERE task_id = ?";

        // Prepare the statement
        $stmt = $connection->prepare($sql);

        // Bind the parameters
        $stmt->bind_param("ii", $schedule, $taskId);

        // Execute the statement
        if ($stmt->execute()) {
            // Task updated successfully
            $response = array(
                'success' => true,
                'message' => 'Task updated successfully.'
            );
            http_response_code(200); // Set HTTP status code to 200 (OK)
        } else {
            // Error updating task
            $response = array(
                'success' => false,
                'message' => 'Error updating task.'
            );
            http_response_code(500); // Set HTTP status code to 500 (Internal Server Error)
        }
    } else {
        // Invalid or incomplete data
        $response = array(
            'success' => false,
            'message' => 'Invalid or incomplete data.'
        );
        http_response_code(400); // Set HTTP status code to 400 (Bad Request)
    }
} else {
    // Invalid request method
    $response = array(
        'success' => false,
        'message' => 'Invalid request method.'
    );
    http_response_code(405); // Set HTTP status code to 405 (Method Not Allowed)
}

// Send the JSON response
echo json_encode($response);
?>