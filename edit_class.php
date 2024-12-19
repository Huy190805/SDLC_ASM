<?php
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php"); // Redirect to login if not logged in or not an admin
    exit();
}

include('includes/header.php'); // Include header file
include('db_connect.php'); // Include database connection

// Get the class ID from the URL
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Get the current class name
    $sql = "SELECT * FROM classes WHERE class_id = $class_id";
    $result = mysqli_query($conn, $sql);
    $class = mysqli_fetch_assoc($result);

    // If form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_class_name = $_POST['new_class_name'];

        // Update class name in the database
        $update_sql = "UPDATE classes SET class_name = '$new_class_name' WHERE class_id = $class_id";
        if (mysqli_query($conn, $update_sql)) {
            echo "<p>Class name updated successfully!</p>";
            header("Location: manage_classes.php"); // Redirect back to manage classes
            exit();
        } else {
            echo "<p>Error updating class name: " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    echo "<p>No class selected to edit.</p>";
}

?>

<div class="container">
    <h2>Edit Class Name</h2>

    <form action="edit_class.php?class_id=<?php echo $class_id; ?>" method="POST">
        <label for="new_class_name">New Class Name</label>
        <input type="text" name="new_class_name" value="<?php echo $class['class_name']; ?>" required>
        <button type="submit">Update Class Name</button>
    </form>

</div>

<?php include('includes/footer.php'); ?>
