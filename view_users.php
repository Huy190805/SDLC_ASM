<?php
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php"); // Redirect to login if not logged in or not an admin
    exit();
}

include('db_connect.php'); // Include database connection

// SQL query to fetch all users
$query = "SELECT id, username, user_type FROM users";
$result = mysqli_query($conn, $query);

include('includes/header.php'); // Include header file
?>

<div class="container">
    <h2>View Users</h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        // Display user list in a table
        echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>User Type</th>
                    </tr>
                </thead>
                <tbody>";
        
        // Fetch and display each user
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['user_type']) . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No users found.</p>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <!-- Back to Admin Dashboard Button -->
    <button class="btn btn-primary" onclick="window.location.href='admin.php'">Back to Dashboard</button>
</div>

<?php include('includes/footer.php'); ?>
