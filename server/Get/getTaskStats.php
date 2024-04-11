<?php
// Enable error reporting
error_reporting(E_ALL);

// Display errors
ini_set('display_errors', 1);
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

// Initialize the response array
$response = array();

// Check if the user is logged in
if (!checkLogin()) {
    $response['success'] = false;
    $response['message'] = "Restricted access.";

    // Output the response as JSON and exit
    echo json_encode($response);
    exit;
}


// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Perform the SQL query to retrieve the data from the tables
    $sql = "SELECT 
                t.task_id,
                t.plant_id,
                a.activity_id,
                a.activity_name AS care_title,
                ts.status_id,
                ts.status_name AS status,
                s.schedule_name AS schedule,
                COALESCE(cs.activity_count, 0) AS activity_count,
                COALESCE(cs.last_update_date, t.last_updated) AS last_updated,
                t.created_at
            FROM 
                Tasks t
            INNER JOIN 
                Care_activities a ON t.activity_id = a.activity_id
            INNER JOIN 
                Schedule s ON t.schedule_id = s.schedule_id
            INNER JOIN 
                Task_Statuses ts ON t.status_id = ts.status_id
            LEFT JOIN 
                Care_Stats cs ON t.plant_id = cs.plant_id AND t.activity_id = cs.activity_id";

    // Execute the query
    $result = $connection->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Initialize an array to store the results
        $data = array();

        // Fetch data from the result set
        while ($row = $result->fetch_assoc()) {
            // Add each row to the data array
            $data[] = $row;
        }

        // Set the response data
        $response['success'] = true;
        $response['data'] = $data;
    } else {
        // If no results found
        $response['success'] = false;
        $response['message'] = 'No data found';
    }
} else {
    // If request method is not GET
    $response['success'] = false;
    $response['message'] = 'Invalid request method';
}

// Set the response headers to indicate JSON content
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);

// Close the database connection
$connection->close();
?>