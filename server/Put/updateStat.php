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

    if (isset($data['stat_id'])) {
        $stat_id = $data['stat_id'];

        // Prepare the UPDATE statement for Care_Stats
        $query = "UPDATE Care_Stats
        SET activity_count = activity_count + 1
        WHERE care_stat_id = ?;
        ";

        // Prepare the statement
        $stmt = $connection->prepare($query);

        // Bind parameters
        $stmt->bind_param("i", $stat_id);

        // Execute the query using the connection from the connection file
        if ($stmt->execute()) {

            // Prepare the UPDATE statement for Tasks
            $query = "UPDATE Tasks
            SET status_id = 1
            WHERE task_id = ?;
            ";

            // Prepare the statement
            $stmt = $connection->prepare($query);

            // Bind parameters
            $stmt->bind_param("i", $stat_id);

            // Execute the query using the connection from the connection file
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Update successfully.";
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to update Tasks.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Failed to update Care_Stats.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Stat Id not included " . $data;
    }
} else {
    // Redirect or show an error message if form is not submitted
    $response['success'] = false;
    $response['message'] = "Server Request Error.";
}

// Encode the response array as JSON and echo it
echo json_encode($response);

// Close the connection
mysqli_close($connection);


