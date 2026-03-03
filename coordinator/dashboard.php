<?php
include('../auth/session_check.php');

if($_SESSION['role'] != 'coordinator'){
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Coordinator Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['name']; ?> 👋</p>

    <div class="mt-4">
        <a href="#" class="btn btn-primary">Manage Events</a>
        <a href="#" class="btn btn-success">Manage Locations</a>
    </div>
</div>

<?php include('../includes/footer.php'); ?>