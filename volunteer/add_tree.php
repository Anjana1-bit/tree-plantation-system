<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../auth/session_check.php');
include('../config/db_connect.php');

/* Role Check */
if($_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

/* ✅ FIXED */
$volunteer_id = $_SESSION['user_id'];

/* Form Submit */
if(isset($_POST['submit'])){

    $species = mysqli_real_escape_string($conn, $_POST['species']);
    $plantation_date = $_POST['plantation_date'];
    $event_id = $_POST['event_id'];

    $query = "
    INSERT INTO trees(species, plantation_date, event_id, volunteer_id)
    VALUES('$species','$plantation_date','$event_id','$volunteer_id')
    ";

    if(!mysqli_query($conn, $query)){
        die("Database Error: " . mysqli_error($conn));
    }

    header("Location: dashboard.php");
    exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Add Tree</h2>
<p class="text-muted">Record a newly planted tree under a plantation event.</p>

<hr>

<form method="POST">

<div class="mb-3">
<label class="form-label">Tree Species</label>
<input type="text" name="species" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Plantation Date</label>
<input type="date" name="plantation_date" class="form-control"
max="<?php echo date('Y-m-d'); ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Plantation Event</label>

<select name="event_id" class="form-control" required>
<option value="">Select Event</option>

<?php
$query = "
SELECT e.event_id, e.event_name, l.location_name
FROM plantation_events e
JOIN locations l ON e.location_id = l.location_id
ORDER BY e.event_date DESC
";

$result = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){
?>

<option value="<?php echo $row['event_id']; ?>">
<?php echo $row['event_name']." - ".$row['location_name']; ?>
</option>

<?php } ?>

</select>

</div>

<button type="submit" name="submit" class="btn btn-success">
Add Tree
</button>

<a href="dashboard.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

<?php include('../includes/footer.php'); ?>