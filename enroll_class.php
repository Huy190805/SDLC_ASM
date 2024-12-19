<?php
session_start(); // Start the session
include('db_connect.php'); // Include database connection

// Check if the student is logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'student') {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

$student_id = $_SESSION['user_id']; // Assuming user_id is stored in session
$class_id = $_GET['class_id']; // Get the class_id from the URL

// Check if the student is already enrolled in this class
$enrollment_check = "SELECT * FROM student_classes WHERE student_id = $student_id AND class_id = $class_id";
$enrollment_result = mysqli_query($conn, $enrollment_check);

if (mysqli_num_rows($enrollment_result) == 0) {
    // Enroll the student in the class
    $enroll_sql = "INSERT INTO student_classes (student_id, class_id) VALUES ($student_id, $class_id)";
    
    if (mysqli_query($conn, $enroll_sql)) {
        // Enrollment successful
        header("Location: view_classesstudent.php?status=success");
    } else {
        // Enrollment failed
        header("Location: view_classesstudent.php?status=error");
    }
} else {
    // If the student is already enrolled, redirect to the same page with a message
    header("Location: view_classesstudent.php?status=already_enrolled");
}
?>
