<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'coordinator'){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Total Events organized by this coordinator */

$resultEvents = mysqli_query($conn,"
SELECT COUNT(*) AS total 
FROM plantation_events 
WHERE organized_by='$user_id'
");

$rowEvents = mysqli_fetch_assoc($resultEvents);
$totalEvents = $rowEvents['total'];


/* Total Locations */

$resultLocations = mysqli_query($conn,"
SELECT COUNT(*) AS total 
FROM locations
");

$rowLocations = mysqli_fetch_assoc($resultLocations);
$totalLocations = $rowLocations['total'];

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Coordinator Dashboard</h2>

<p>Welcome, <?php echo $_SESSION['name']; ?> 👋</p>



<div class="row">

<!-- Total Events -->

<div class="col-md-6 mb-3">
<div class="card shadow-sm text-center">
<div class="card-body">

<h5>Total Events</h5>

<h3><?php echo $totalEvents; ?></h3>

</div>
</div>
</div>


<!-- Total Locations -->

<div class="col-md-6 mb-3">
<div class="card shadow-sm text-center">
<div class="card-body">

<h5>Total Locations</h5>

<h3><?php echo $totalLocations; ?></h3>

</div>
</div>
</div>

</div>

</div>

<?php include('../includes/footer.php'); ?>