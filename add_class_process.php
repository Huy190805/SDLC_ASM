<?php
session_start(); // Start the session
include('db_connect.php'); // Include database connection

// Check if teacher is logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'teacher') {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

// Get the class name from the POST request
if (isset($_POST['class_name'])) {
    $class_name = $_POST['class_name'];

    // Prepare the SQL statement to insert the new class into the classes table
    $sql = "INSERT INTO classes (class_name) VALUES ('$class_name')";

    // Execute the queryx   
    if (mysqli_query($conn, $sql)) {
        echo "Class added successfully!";
        header("Location: home_teacher.php"); // Redirect back to teacher dashboard
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn); // Close the database connection
?>
