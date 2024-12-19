<?php
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php"); // Redirect to login if not logged in or not an admin
    exit();
}

include('includes/header.php'); // Include header file
include('db_connect.php'); // Include database connection

// Initialize error message variable
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];
    
    // Validate input
    if (empty($full_name) || empty($email) || empty($username) || empty($password) || empty($user_type)) {
        $error = "All fields are required!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Check if the username or email already exists
        $check_user_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($conn, $check_user_sql);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Username or Email already exists!";
        } else {
            // Insert the new user into the database
            $insert_sql = "INSERT INTO users (full_name, email, username, password, user_type) 
                           VALUES ('$full_name', '$email', '$username', '$hashed_password', '$user_type')";
            if (mysqli_query($conn, $insert_sql)) {
                header("Location: admin.php"); // Redirect back to the admin dashboard
                exit();
            } else {
                $error = "Error adding user: " . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="container">
    <h2>Add New User</h2>

    <?php
    if ($error != "") {
        echo "<p style='color: red;'>$error</p>"; // Display error messages
    }
    ?>

    <form action="add_user.php" method="POST">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="user_type">User Type</label>
        <select name="user_type" id="user_type" required>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>

        <div>
            <button type="submit">Add User</button>
            <button onclick="window.location.href='admin.php'">Back to Home</button>


            </div>
        

    </form>

</div>

<?php include('includes/footer.php'); ?>

