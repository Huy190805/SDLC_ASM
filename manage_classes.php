<?php
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php"); // Redirect to login if not logged in or not an admin
    exit();
}

include('includes/header.php'); // Include header file
include('db_connect.php'); // Include database connection

// Handle class deletion
if (isset($_GET['delete_class_id'])) {
    $class_id = $_GET['delete_class_id'];

    // Delete the class from the database
    $delete_sql = "DELETE FROM classes WHERE class_id = $class_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<p>Class deleted successfully!</p>";
    } else {
        echo "<p>Error deleting class: " . mysqli_error($conn) . "</p>";
    }
}

// Handle class name update
if (isset($_POST['update_class_name'])) {
    $new_class_name = $_POST['new_class_name'];
    $class_id = $_POST['class_id'];

    // Update the class name in the database
    $update_sql = "UPDATE classes SET class_name = '$new_class_name' WHERE class_id = $class_id";
    if (mysqli_query($conn, $update_sql)) {
        echo "<p>Class name updated successfully!</p>";
    } else {
        echo "<p>Error updating class name: " . mysqli_error($conn) . "</p>";
    }
}

// Get the list of classes
$sql = "SELECT * FROM classes";
$result = mysqli_query($conn, $sql);

?>

<div class="container">
    <h2>Manage Classes</h2>
    <p>Welcome, <?php echo $_SESSION['username']; ?>! Here you can manage the classes.</p>

    <!-- List all classes with options to delete or edit -->
    <table border="1">
        <tr>
            <th>Class Name</th>
            <th>Action</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['class_name'] . "</td>";
                echo "<td>
                        <a href='?delete_class_id=" . $row['class_id'] . "' onclick='return confirm(\"Are you sure you want to delete this class?\")'>Delete</a>
                        | <a href='edit_class.php?class_id=" . $row['class_id'] . "'>Edit</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No classes available</td></tr>";
        }
        ?>
        
    </table>
    <button onclick="window.location.href='admin.php'">Back to Home</button>


</div>

<?php include('includes/footer.php'); ?>

