<?php
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php"); // Redirect to login if not logged in or not an admin
    exit();
}

include('includes/header.php'); // Include header file
include('db_connect.php'); // Include database connection

?>

<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p> <!-- Display admin's username -->


    <button onclick="window.location.href='add_user.php'">Add User</button>
    <button onclick="window.location.href='manage_classes.php'">Manage Classes</button>
    <button class="btn btn-success" onclick="window.location.href='view_users.php'">View Users</button>
    <button onclick="window.location.href='logout.php'">Logout</button>


</div>

<?php include('includes/footer.php'); ?>


