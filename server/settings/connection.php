<?php
// Use mysqli connection method
$connection = new mysqli('localhost', 'root', "", 'greenHouse');

// Check if connection worked
if ($connection->connect_error) {
    // Use the die() function if connection fails and display error.
    $send = array();
    $send['success'] = false;
    $send['message'] = "database error.";
    echo json_encode($response);
   
    die("Connection failed: " . $connection->connect_error);
    exit();

}

