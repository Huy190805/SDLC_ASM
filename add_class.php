<?php
session_start(); // Start the session
include('includes/header.php');
include('db_connect.php'); // Include database connection

// Check if the teacher is logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'teacher') {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

$teacher_id = $_SESSION['user_id']; // Assuming the user_id is stored in session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get class name from form
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
    
    // Insert class into classes table
    $sql = "INSERT INTO classes (class_name) VALUES ('$class_name')";
    
    if (mysqli_query($conn, $sql)) {
        // Get the ID of the newly inserted class
        $class_id = mysqli_insert_id($conn);

        // Assign teacher to the class
        $sql_teacher_class = "INSERT INTO teacher_subject_class (teacher_id, class_id) VALUES ('$teacher_id', '$class_id')";
        
        if (mysqli_query($conn, $sql_teacher_class)) {
            echo "<p>Class added successfully and assigned to you!</p>";
        } else {
            echo "<p>Error assigning class to teacher.</p>";
        }
    } else {
        echo "<p>Error creating class.</p>";
    }
}
?>

<div class="container">
    <h2>Add Class</h2>

    <form method="POST">
        <label for="class_name">Class Name:</label>
        <input type="text" id="class_name" name="class_name" required><br><br>
        <button type="submit">Add Class</button>
        <button onclick="window.location.href='home_teacher.php'">Back to Home</button>

    </form>
   

    <link rel="stylesheet" href="style.css">
</div>

<?php include('includes/footer.php'); ?>

<style>
    form {
    width: 300px;
    margin: 0 auto;
}

input[type="text"] {
    width: 100%;
    padding: 0.5rem;
    margin: 0.5rem 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 0.5rem;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

a {
    display: block;
    text-align: center;
    margin-top: 10px;
}

</style>