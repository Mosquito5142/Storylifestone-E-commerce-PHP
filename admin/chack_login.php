<?php
// Start the session
session_start();

// Check if admin_name is not set, meaning user is not logged in
if (!isset($_SESSION['admin_name'])) {
    // Redirect to the login page
    header('Location: login_admin.php');
    exit(); // Make sure to exit after a header redirect
}

// If admin_name is set, the user is logged in
// You can proceed with rendering the content of admin_index.php

// Include your database connection file
include '../config.php';

// ... rest of your code ...
?>
