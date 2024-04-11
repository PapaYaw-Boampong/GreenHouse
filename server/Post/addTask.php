<?php
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

// Initialize response array
$response = array();

// Check if user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";
    echo json_encode($response);
    exit();
}

global $connection;

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the request
    $activity_id = $connection->real_escape_string($_POST['pc-name']);
    $plant_id = $connection->real_escape_string($_POST['plant_id']);
    $schedule_id = $connection->real_escape_string($_POST['pc-schedule']);


    // Prepare the SELECT statement to check for duplicates
    $query = "SELECT * FROM Tasks WHERE activity_id = ? AND plant_id = ?";

    // Prepare the statement
    $stmt = $connection->prepare($query);

    // Bind parameters
    $stmt->bind_param("ii", $activity_id, $plant_id);

    // Execute the query
    $stmt->execute();

    // Store the result
    $stmt->store_result();

    // Check if any rows were returned
    if ($stmt->num_rows > 0) {
        // If a duplicate exists
        $response['success'] = false;
        $response['message'] = "Duplicate record exists.";
    } else {
        // Prepare the INSERT statement for Tasks table
        $tasks_query = "INSERT INTO Tasks (plant_id, activity_id, schedule_id, status_id) VALUES (?, ?, ?, ?)";

        // Prepare the statement for Tasks table
        $tasks_stmt = $connection->prepare($tasks_query);
        $status_id = 2; // Assuming status_id for incomplete task

        // Bind parameters for Tasks table
        $tasks_stmt->bind_param("iiii", $plant_id, $activity_id, $schedule_id, $status_id);

        // Execute the Tasks table query
        if ($tasks_stmt->execute()) {
            $task_id = $tasks_stmt->insert_id; // Get the ID of the inserted task

            // Prepare the INSERT statement for Care_Stats table
            $care_stats_query = "INSERT INTO Care_Stats (task_id, activity_count) VALUES (?, ?)";

            // Prepare the statement for Care_Stats table
            $care_stats_stmt = $connection->prepare($care_stats_query);

            // Assuming initial activity count is 0
            $initial_activity_count = 0;

            // Bind parameters for Care_Stats table
            $care_stats_stmt->bind_param("ii", $task_id, $initial_activity_count);

            // Execute the Care_Stats table query
            if ($care_stats_stmt->execute()) {
                // If insertion into both tables is successful
                $response['success'] = true;
                $response['message'] = "Records inserted successfully into Tasks and Care_Stats tables.";
            } else {
                // If insertion into Care_Stats table fails
                $response['success'] = false;
                $response['message'] = "Failed to insert record into Care_Stats table: " . $connection->error;
            }

            // Close the Care_Stats statement
            $care_stats_stmt->close();
        } else {
            // If insertion into Tasks table fails
            $response['success'] = false;
            $response['message'] = "Failed to insert record into Tasks table: " . $connection->error;
        }
        // Close the Tasks statement
        $tasks_stmt->close();
    }
} else {
    // If request method is not POST
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

// Encode the response array as JSON and echo it
echo json_encode($response);
