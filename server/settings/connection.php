<?php
// Use mysqli connection method
$connection = new mysqli('localhost', 'root', "", 'greenhouse');

// Check if connection worked
if ($connection->connect_error) {
    // Use the die() function if connection fails and display error.
    die("Connection failed: " . $connection->connect_error);

    $send = array();
    $send['success'] = false;
    $send['message'] = "database error.";
    echo json_encode($response);
    exit();
}

?>