<?php
session_start(); // Start the session
include('includes/header.php');
include('db_connect.php'); // Include database connection

// Check if the student is logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'student') {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

// Fetch all classes from the classes table
$sql = "SELECT * FROM classes";
$result = mysqli_query($conn, $sql);

// Check if the student is already enrolled in the class
$student_id = $_SESSION['user_id']; // Assuming user_id is stored in session

?>

<div class="container">
    <h2>View and Enroll in Classes</h2>

    <?php
    // Check if there are any classes
    if (mysqli_num_rows($result) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            $class_name = $row['class_name'];
            $class_id = $row['class_id'];

            // Check if the student is already enrolled in this class
            $enrollment_check = "SELECT * FROM student_classes WHERE student_id = $student_id AND class_id = $class_id";
            $enrollment_result = mysqli_query($conn, $enrollment_check);

            if (mysqli_num_rows($enrollment_result) > 0) {
                $status = "<span class='status'>Already Enrolled</span>";
            } else {
                $status = "<a href='enroll_class.php?class_id=$class_id' class='enroll-btn'>Enroll</a>";
            }

            // Display class and status
            echo "<li>$class_name - $status</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No classes available.</p>";
    }
    ?>

    <?php
    // Status messages
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 'success') {
            echo "<p class='success'>You have successfully enrolled in the class!</p>";
        } elseif ($status == 'error') {
            echo "<p class='error'>There was an error enrolling. Please try again later.</p>";
        } elseif ($status == 'already_enrolled') {
            echo "<p class='info'>You are already enrolled in this class.</p>";
        }
    }
    ?>

<button onclick="window.location.href='home_student.php'">Back to Home</button>
</div>

<?php include('includes/footer.php'); ?>


<style>
    .container {
    width: 80%;
    margin: 0 auto;
    text-align: center;
}

ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    padding: 10px;
    background-color: #f4f4f4;
    margin: 5px 0;
    border-radius: 4px;
}

.enroll-btn {
    display: inline-block;
    padding: 5px 10px;
    background-color: #28a745;
    color: white;
    border-radius: 4px;
    text-decoration: none;
}

.enroll-btn:hover {
    background-color: #218838;
}

.status {
    color: #007bff;
}

.success {
    color: green;
}

.error {
    color: red;
}

.info {
    color: orange;
}

</style>