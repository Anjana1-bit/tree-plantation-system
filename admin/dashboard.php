<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
header("Location: ../auth/login.php");
exit();
}

/* Dashboard Statistics */

// Total Trees
$resultTrees = mysqli_query($conn,"SELECT COUNT(*) as total FROM trees");
$totalTrees = mysqli_fetch_assoc($resultTrees)['total'];

// Alive Trees
$resultAlive = mysqli_query($conn,"SELECT COUNT(*) as total FROM trees WHERE survival_status='Alive'");
$aliveTrees = mysqli_fetch_assoc($resultAlive)['total'];

// Dead Trees
$resultDead = mysqli_query($conn,"SELECT COUNT(*) as total FROM trees WHERE survival_status='Dead'");
$deadTrees = mysqli_fetch_assoc($resultDead)['total'];

// Events
$resultEvents = mysqli_query($conn,"SELECT COUNT(*) as total FROM plantation_events");
$totalEvents = mysqli_fetch_assoc($resultEvents)['total'];

// Volunteers
$resultVolunteers = mysqli_query($conn,"SELECT COUNT(*) as total FROM volunteers");
$totalVolunteers = mysqli_fetch_assoc($resultVolunteers)['total'];

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<div class="mb-4">
<h2>🌿 Admin Dashboard</h2>
<p class="text-muted">
Welcome, <?php echo $_SESSION['name'] ?? 'Admin'; ?> 👋
</p>
</div>

<div class="row g-4">

<!-- Total Trees -->

<div class="col-md-4">
<div class="card shadow-sm">
<div class="card-body text-center">

<h5>Total Trees</h5>
<h2><?php echo $totalTrees; ?></h2>

</div>
</div>
</div>


<!-- Alive Trees -->

<div class="col-md-4">
<div class="card shadow-sm">
<div class="card-body text-center">

<h5>Alive Trees</h5>
<h2><?php echo $aliveTrees; ?></h2>

</div>
</div>
</div>


<!-- Dead Trees -->

<div class="col-md-4">
<div class="card shadow-sm">
<div class="card-body text-center">

<h5>Dead Trees</h5>
<h2><?php echo $deadTrees; ?></h2>

</div>
</div>
</div>


<!-- Events -->

<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body text-center">

<h5>Total Plantation Events</h5>
<h2><?php echo $totalEvents; ?></h2>

</div>
</div>
</div>


<!-- Volunteers -->

<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body text-center">

<h5>Total Volunteers</h5>
<h2><?php echo $totalVolunteers; ?></h2>

</div>
</div>
</div>

</div>

</div>

<?php include('../includes/footer.php'); ?>