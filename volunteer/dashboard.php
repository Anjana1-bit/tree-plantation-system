<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// Volunteer Role Protection
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

$volunteer_id = $_SESSION['user_id'];

// Total Trees planted by this volunteer
$resultTrees = mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM trees 
     WHERE volunteer_id = $volunteer_id"
);
$totalTrees = $resultTrees ? mysqli_fetch_assoc($resultTrees)['total'] : 0;

// Alive Trees
$resultAlive = mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM trees 
     WHERE volunteer_id = $volunteer_id 
     AND survival_status = 'Alive'"
);
$aliveTrees = $resultAlive ? mysqli_fetch_assoc($resultAlive)['total'] : 0;

// Dead Trees
$resultDead = mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM trees 
     WHERE volunteer_id = $volunteer_id 
     AND survival_status = 'Dead'"
);
$deadTrees = $resultDead ? mysqli_fetch_assoc($resultDead)['total'] : 0;

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <div class="mb-4">
<h2>🌿 Volunteer Dashboard</h2>
<p class="text-muted">
Welcome, <?php echo $_SESSION['name'] ?? 'Volunteer'; ?> 👋
</p>
</div>

    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Trees Planted</h5>
                    <h3 class="text-success"><?php echo $totalTrees; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Alive Trees</h5>
                    <h3 class="text-primary"><?php echo $aliveTrees; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Dead Trees</h5>
                    <h3 class="text-danger"><?php echo $deadTrees; ?></h3>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include('../includes/footer.php'); ?>