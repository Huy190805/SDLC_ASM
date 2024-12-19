<?php
session_start();
include('db_connect.php'); // Database connection

// Collect and sanitize form input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];
$user_type = $_POST['user_type'];

// Query the database for the user with the provided username and user type
$query = "SELECT * FROM users WHERE username='$username' AND user_type='$user_type'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Verify the password
    if (password_verify($password, $row['password'])) {
        // Store user data in session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_type'] = $row['user_type'];
        
        // Redirect based on user type
        if ($row['user_type'] == 'admin') {
            header('Location: admin.php');
        } elseif ($row['user_type'] == 'teacher') {
            header('Location: home_teacher.php');
        } elseif ($row['user_type'] == 'student') {
            header('Location: home_student.php');
        }
        exit();
    } else {
        echo "Invalid password!";
    }
} else {
    echo "No user found with that username!";
}

$_SESSION['user_id'] = $user['id']; // Store user ID
$_SESSION['username'] = $user['username']; // Store username
$_SESSION['user_type'] = $user['user_type']; // Store user type (teacher, admin, student)

mysqli_close($conn);
?>
