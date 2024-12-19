<?php
session_start();
include('db_connect.php'); // Database connection

// Collect and sanitize form data
$user_type = $_POST['user_type'];
$full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate that passwords match
if ($password !== $confirm_password) {
    echo "Passwords do not match!";
    exit();
}

// Check if username or email already exists
$query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "Username or Email already exists!";
    exit();
}

// Hash the password before storing it
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user into the database
$query = "INSERT INTO users (user_type, full_name, email, username, password) 
          VALUES ('$user_type', '$full_name', '$email', '$username', '$hashed_password')";
if (mysqli_query($conn, $query)) {
    echo "Registration successful!";
    header('Location: login.php'); // Redirect to the login page after successful registration
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
