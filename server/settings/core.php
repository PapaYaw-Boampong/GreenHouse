<?php
session_start();
function checkLogin(){
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page
        return false;
    } else {
        return True;
    }
}
?>