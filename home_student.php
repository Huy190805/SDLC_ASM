<?php
session_start(); // Start the session
include('includes/header.php');
?>

<div class="container">
    <h2>Student Dashboard</h2>
    <p>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></p>
    <div>
        <button onclick="window.location.href='view_classesstudent.php'">View Classes</button>
    </div>
    <!-- Logout Button -->
    <form action="logout.php" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>









    
</div>

<?php include('includes/footer.php'); ?>


