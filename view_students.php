<?php
session_start(); // Start the session
include('includes/header.php');
include('db_connect.php'); // Include database connection

// Check if the teacher is logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'teacher') {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

// Get teacher's user ID
$teacher_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Fetch classes taught by the teacher
$sql_classes = "SELECT teacher_subject_class.class_id FROM teacher_subject_class WHERE teacher_subject_class.teacher_id = $teacher_id";
$result_classes = mysqli_query($conn, $sql_classes);

// Check if the teacher is assigned any classes
if (mysqli_num_rows($result_classes) > 0) {
    // Fetch and display students enrolled in each class
    while ($row = mysqli_fetch_assoc($result_classes)) {
        $class_id = $row['class_id'];

        // Get the class name from the classes table
        $sql_class_name = "SELECT class_name FROM classes WHERE class_id = $class_id";
        $result_class_name = mysqli_query($conn, $sql_class_name);
        $class_name = mysqli_fetch_assoc($result_class_name)['class_name'];

        // Fetch students enrolled in this class
        $sql_students = "SELECT users.full_name, users.username FROM users
                        JOIN student_classes ON users.id = student_classes.student_id
                        WHERE student_classes.class_id = $class_id";
        $result_students = mysqli_query($conn, $sql_students);

        echo "<h3>Class: " . $class_name . "</h3>"; // Use class name here
        
        if (mysqli_num_rows($result_students) > 0) {
            echo "<ul>";
            while ($student = mysqli_fetch_assoc($result_students)) {
                echo "<li>" . $student['full_name'] . " (" . $student['username'] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No students enrolled in this class.</p>";
        }
    }
} else {
    echo "<p>You are not assigned to any classes yet.</p>";
}

?>

<button onclick="window.location.href='home_teacher.php'">Back to Home</button>

<?php include('includes/footer.php'); ?>

<link rel="stylesheet" href="style.css">

<style>
    table {
    width: 100%;
    border-collapse: collapse;
}
body{
    text-align: justify;
}


table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

</style>