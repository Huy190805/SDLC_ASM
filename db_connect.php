<?php
$servername = "localhost";
$username = "root"; // default XAMPP MySQL username
$password = "";     // default XAMPP MySQL password (empty)
$dbname = "school_management"; // Database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
