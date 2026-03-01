<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// =====================
// Admin Role Protection
// =====================
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

// ======================
// Dashboard Statistics
// ======================

// Total Trees
$resultTrees = mysqli_query($conn, "SELECT COUNT(*) as total FROM trees");
$totalTrees = mysqli_fetch_assoc($resultTrees)['total'];

// Total Volunteers
$resultVolunteers = mysqli_query($conn, "SELECT COUNT(*) as total FROM volunteers");
$totalVolunteers = mysqli_fetch_assoc($resultVolunteers)['total'];

// Total Events
$resultEvents = mysqli_query($conn, "SELECT COUNT(*) as total FROM plantation_events");
$totalEvents = mysqli_fetch_assoc($resultEvents)['total'];

// Survived Trees
$resultAlive = mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM trees WHERE survival_status='Alive'"
);
$aliveTrees = mysqli_fetch_assoc($resultAlive)['total'];

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2 class="mb-4">Admin Overview</h2>

    <div class="row">

        <!-- Total Trees -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Total Trees</h5>
                    <h3 class="text-success">
                        <?php echo $totalTrees; ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Total Volunteers -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Total Volunteers</h5>
                    <h3 class="text-primary">
                        <?php echo $totalVolunteers; ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Total Events -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Total Events</h5>
                    <h3 class="text-warning">
                        <?php echo $totalEvents; ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Survived Trees -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Survived Trees</h5>
                    <h3 class="text-danger">
                        <?php echo $aliveTrees; ?>
                    </h3>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include('../includes/footer.php'); ?>