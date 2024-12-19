<?php
session_start(); // Start the session
include('includes/header.php');
include('db_connect.php'); // Include the database connection

// Check if the teacher is logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'teacher') {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

// Query to fetch the classes the teacher is associated with
$teacher_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login
$sql = "SELECT classes.class_name FROM classes 
        INNER JOIN teacher_subject_class 
        ON classes.class_id = teacher_subject_class.class_id 
        WHERE teacher_subject_class.teacher_id = '$teacher_id'";

$result = mysqli_query($conn, $sql);

?>

<div class="container">
    <h2>Your Classes</h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Class Name</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['class_name'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>You are not assigned to any classes yet.</p>";
    }
    ?>
    <button onclick="window.location.href='home_teacher.php'">Back to Home</button>

</div>

<?php include('includes/footer.php'); ?>
<link rel="stylesheet" href="style.css">

<style>
    table {
    width: 100%;
    border-collapse: collapse;
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
