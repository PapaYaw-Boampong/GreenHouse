<?php
// Initialize response array
$response = array();

// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

global $connection;

if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";

    echo json_encode($response);
    exit;
}

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if plant ID is provided
    if (isset($_GET['plant_id'])) {
        // Get the plant ID from the request
        $plant_id = $_GET['plant_id'];

        // Prepare SQL query to fetch task data for the provided plant ID
        $sql = "SELECT 
        T.*,
        CA.activity_id,
        CA.activity_name,
        CA.description AS activity_description,
        S.schedule_id,
        S.schedule_name,
        TS.status_id,
        TS.status_name,
        CS.activity_count,
        CS.last_update_date AS last_activity_update
    FROM 
        Tasks T
    JOIN 
        Plants P ON T.plant_id = P.plant_id
    JOIN 
        Care_activities CA ON T.activity_id = CA.activity_id
    JOIN 
        Schedule S ON T.schedule_id = S.schedule_id
    JOIN 
        Task_Statuses TS ON T.status_id = TS.status_id
    LEFT JOIN 
        Care_Stats CS ON T.task_id = CS.task_id
    WHERE 
        T.plant_id = $plant_id;
    ";

        // Execute the query
        $result = $connection->query($sql);

        // Check if the query was successful
        if ($result) {
            $tasks = array();
            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Fetch the tasks data
                while ($row = $result->fetch_assoc()) {
                    // Add each task to the array
                    $tasks[] = $row;
                }

                // Set success response with tasks data
                $response['success'] = true;
                $response['message'] = "Tasks retrieved successfully.";
                $response['tasks'] = $tasks;
            } else {
                // No tasks found for the specified plant ID
                $response['success'] = true;
                $response['message'] = "No tasks found for the specified plant ID.";
                $response['tasks'] = $tasks;
            }
        } else {
            // Query execution failed
            $response['success'] = false;
            $response['message'] = "Error executing SQL query.";
        }
    } else {
        // Plant ID not provided
        $response['success'] = false;
        $response['message'] = "Plant ID not provided.";
    }
} else {
    // If request method is not GET
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

// Close the connection
$connection->close();

// Encode the response array as JSON and echo it
echo json_encode($response);
