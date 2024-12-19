<?php
session_start(); // Start the session
include('includes/header.php');
?>
<?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
    <p class="success">Class added successfully!</p>
<?php } elseif (isset($_GET['status']) && $_GET['status'] == 'error') { ?>
    <p class="error">Error adding class. Please try again.</p>
<?php } ?>

<div class="container"> 
    <h2>Teacher Dashboard</h2>
    <!-- Check if the user is logged in -->
    <p>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></p>

    <!-- Add class and view students buttons -->
   <!-- Add Class Button -->

    <div class="col-4">
        
        <div>
            <button onclick="window.location.href='add_class.php'">Add Class</button>
            <button onclick="window.location.href='view_classes.php'">View Classes</button>

            <button onclick="window.location.href='view_students.php'">View Students</button>

        </div>
        <!-- View Class Button -->
        <div>
        <form action="logout.php" method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
        </div>

        
    </div>
    <!-- Logout Button -->
    
</div>


<?php include('includes/footer.php'); ?>


