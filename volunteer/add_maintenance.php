<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

/* ================= ROLE CHECK ================= */
if($_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

/* ================= SESSION ================= */
$volunteer_id = $_SESSION['user_id'];

/* ================= GET TREE ================= */
if(!isset($_GET['tree_id'])){
    die("No tree selected");
}

$tree_id = $_GET['tree_id'];

/* ================= VALIDATE TREE ================= */
$tree = mysqli_query($conn,"
SELECT * FROM trees
WHERE tree_id='$tree_id'
AND volunteer_id='$volunteer_id'
");

if(mysqli_num_rows($tree) == 0){
    die("Invalid tree");
}

$data = mysqli_fetch_assoc($tree);

/* ================= BLOCK DEAD TREE ================= */
if($data['survival_status'] == 'Dead'){
    echo "<script>
            alert('Cannot maintain dead tree');
            window.location='view_my_trees.php';
          </script>";
    exit();
}

/* ================= LAST MAINTENANCE ================= */
$last_maintenance = mysqli_query($conn,"
SELECT maintenance_date, activity_type 
FROM maintenance_records
WHERE tree_id='$tree_id'
ORDER BY maintenance_date DESC
LIMIT 1
");

$last_data = mysqli_fetch_assoc($last_maintenance);

/* ================= SUBMIT ================= */
if(isset($_POST['submit'])){

    $date = $_POST['maintenance_date'];
    $activity = mysqli_real_escape_string($conn, $_POST['activity_type']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);

    /* ❌ DATE VALIDATION (ONLY CHRONOLOGY) */
    if($last_data && $date <= $last_data['maintenance_date']){
        echo "<script>alert('Date must be after last maintenance');</script>";
    }

    else{

        mysqli_query($conn,"
        INSERT INTO maintenance_records
        (tree_id, volunteer_id, maintenance_date, activity_type, remarks)
        VALUES
        ('$tree_id','$volunteer_id','$date','$activity','$remarks')
        ");

        echo "<script>
                alert('Maintenance added successfully');
                window.location='view_maintenance.php?tree_id=$tree_id';
              </script>";
        exit();
    }
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Add Maintenance</h2>

<p class="text-muted">
Tree: <strong><?php echo htmlspecialchars($data['species']); ?></strong>
</p>

<p class="text-muted">
Planted on: <?php echo $data['plantation_date']; ?>
</p>

<!-- LAST MAINTENANCE -->
<?php if($last_data): ?>
<div class="alert alert-info">
<strong>Last Maintenance:</strong><br>
Date: <?php echo $last_data['maintenance_date']; ?><br>
Activity: <?php echo htmlspecialchars($last_data['activity_type']); ?>
</div>
<?php else: ?>
<div class="alert alert-warning">
No previous maintenance record found.
</div>
<?php endif; ?>

<hr>

<form method="POST">

<div class="mb-3">
<label class="form-label">Maintenance Date</label>
<input type="date" name="maintenance_date"
class="form-control"
min="<?php echo $last_data ? $last_data['maintenance_date'] : $data['plantation_date']; ?>"
required>
</div>

<div class="mb-3">
<label class="form-label">Activity Type</label>
<input type="text" name="activity_type"
class="form-control"
placeholder="Watering, Fertilizing, Cleaning..."
required>
</div>

<div class="mb-3">
<label class="form-label">Remarks (Optional)</label>
<textarea name="remarks"
class="form-control"
placeholder="Additional notes..."></textarea>
</div>

<button type="submit" name="submit"
class="btn btn-success">
Add Maintenance
</button>

<a href="view_my_trees.php"
class="btn btn-secondary">
Cancel
</a>

</form>

</div>

<?php include('../includes/footer.php'); ?>