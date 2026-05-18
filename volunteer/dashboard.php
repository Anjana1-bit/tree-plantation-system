<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// Role check
if($_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

// ✅ Use unified session key
$volunteer_id = $_SESSION['user_id'];

/* ======================
   FETCH DATA
====================== */

// Total Trees
$result1 = mysqli_query($conn,"
SELECT COUNT(*) AS total_trees
FROM trees
WHERE volunteer_id='$volunteer_id'
");

$data1 = mysqli_fetch_assoc($result1);
$total_trees = $data1['total_trees'] ?? 0;


// Events Participated
$result2 = mysqli_query($conn,"
SELECT COUNT(DISTINCT event_id) AS total_events
FROM trees
WHERE volunteer_id='$volunteer_id'
");

$data2 = mysqli_fetch_assoc($result2);
$total_events = $data2['total_events'] ?? 0;

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<!-- ================= HEADER ================= -->
<div class="mb-4">
    <h2>🌿 Volunteer Dashboard</h2>
    <p class="text-muted">
        Welcome, <?php echo $_SESSION['name'] ?? 'Volunteer'; ?> 👋
    </p>
</div>

<hr>

<!-- ================= CARDS ================= -->
<div class="row g-4">

    <!-- Total Trees -->
    <div class="col-md-6 col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="text-muted">Total Trees Planted</h5>
                <h2 class="text-success"><?php echo $total_trees; ?></h2>
            </div>
        </div>
    </div>

    <!-- Events -->
    <div class="col-md-6 col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="text-muted">Events Participated</h5>
                <h2 class="text-primary"><?php echo $total_events; ?></h2>
            </div>
        </div>
    </div>

</div>

</div>

<?php include('../includes/footer.php'); ?>