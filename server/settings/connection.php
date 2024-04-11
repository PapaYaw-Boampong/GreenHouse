<?php
// Use mysqli connection method
$connection = new mysqli('localhost', 'root', "", 'greenHouse');

// Check if connection worked
if ($connection->connect_error) {
    // Use the die() function if connection fails and display error.
    die("Connection failed: " . $connection->connect_error);
}
