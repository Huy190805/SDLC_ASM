<?php
session_start(); // Start the session

// Destroy all session data
session_destroy();

// Redirect to login page
header("Location: login.php"); // Redirect to login page (index.php)
exit();
?>
