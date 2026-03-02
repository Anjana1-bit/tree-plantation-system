<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// Admin Role Protection
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

// ======================
// Dashboard Statistics
// ======================

// Total Trees
$resultTrees = mysqli_query($conn, "SELECT COUNT(*) as total FROM trees");
$totalTrees = $resultTrees ? mysqli_fetch_assoc($resultTrees)['total'] : 0;

// Alive Trees
$resultAlive = mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM trees WHERE survival_status='Alive'"
);
$aliveTrees = $resultAlive ? mysqli_fetch_assoc($resultAlive)['total'] : 0;

// Dead Trees
$resultDead = mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM trees WHERE survival_status='Dead'"
);
$deadTrees = $resultDead ? mysqli_fetch_assoc($resultDead)['total'] : 0;

// Total Events
$resultEvents = mysqli_query($conn, "SELECT COUNT(*) as total FROM plantation_events");
$totalEvents = $resultEvents ? mysqli_fetch_assoc($resultEvents)['total'] : 0;

// Total Volunteers
$resultVolunteers = mysqli_query($conn, "SELECT COUNT(*) as total FROM volunteers");
$totalVolunteers = $resultVolunteers ? mysqli_fetch_assoc($resultVolunteers)['total'] : 0;

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2 class="mb-4">Admin Overview</h2>

    <div class="row">

        <!-- Total Trees -->
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Trees</h5>
                    <h3 class="text-success"><?php echo $totalTrees; ?></h3>
                </div>
            </div>
        </div>

        <!-- Alive Trees -->
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Alive Trees</h5>
                    <h3 class="text-primary"><?php echo $aliveTrees; ?></h3>
                </div>
            </div>
        </div>

        <!-- Dead Trees -->
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Dead Trees</h5>
                    <h3 class="text-danger"><?php echo $deadTrees; ?></h3>
                </div>
            </div>
        </div>

        <!-- Total Events -->
        <div class="col-md-6 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Events</h5>
                    <h3 class="text-info"><?php echo $totalEvents; ?></h3>
                </div>
            </div>
        </div>

        <!-- Total Volunteers -->
        <div class="col-md-6 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Volunteers</h5>
                    <h3 class="text-warning"><?php echo $totalVolunteers; ?></h3>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include('../includes/footer.php'); ?>