<?php
// Include the connection file
include '../settings/connection.php';
include '../settings/core.php';

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

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (!isset($_GET['plant_id'])) {
        $response['success'] = false;
        $response['message'] = "Request Missing plant_id param";
        $response['plantCare'] = $plantCare;

        echo json_encode($response);
        exit;
    }

    // Prepare SQL statement to select plant care information by user ID
    $sql = "SELECT
    Plant_Care.*,
    Care_activities.activity_name,
    Care_activities.description,
    Care_activities.custom
    FROM
    Plant_Care
    INNER JOIN
    Care_activities ON Plant_Care.activity_id = Care_activities.activity_id
    WHERE
    Plant_Care.plant_id = ?;
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
        $response['plantCare'] = $plantCare;
    }

    // Close the statement
    $stmt->close();
}

// Encode the response array as JSON and echo it
echo json_encode($response);
?>