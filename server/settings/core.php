<?php
// Start the session
session_start();
// Function to check for login using user ID session

function checkLogin()
{
    // Check if user ID session exists
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page
        return false;
    } else {
        return True;
    }
}
