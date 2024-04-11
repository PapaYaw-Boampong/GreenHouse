<?php
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;



// Initialize response array
$response = array();

// Check if user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

$json = file_get_contents('php://input');

$data = json_decode($json, true);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentDate = new DateTime();

    if (isset($data['plant_Id'])) {
        $plant_id = $data['plant_Id'];
        // Get all tasks and their associated care activities
        $query = "SELECT T.task_id, CS.last_update_date
        FROM Tasks T
        JOIN Care_Stats CS ON T.task_id = CS.task_id WHERE T.plant_id = $plant_id";
        $result = $connection->query($query);


        if ($result->num_rows > 0) {
            // Loop through each task
            while ($row = $result->fetch_assoc()) {
                $lastUpdateDate = new DateTime($row['last_update_date']);
                $lastUpdateDateString = $lastUpdateDate->format('Y-m-d');
                $currentDateString = $currentDate->format('Y-m-d');
                // If the last update date is in the past
                if ($lastUpdateDateString < $currentDateString) {

                    $query = "UPDATE Tasks
                SET status_id = 2
                WHERE task_id = " . $row['task_id'];
                    $connection->query($query);
                }
            }
            $response['success'] = true;
            $response['message'] = "Update successfully.";
        } else {
            $response['success'] = true;
            $response['message'] = "No tasks found";
        }
    }else{
        $response['success'] = false;
            $response['message'] = "plant id not passed";
    }
} else {
    // If request method is not GET
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}


// Encode the response array as JSON and echo it
echo json_encode($response);

// Close the connection
mysqli_close($connection);
