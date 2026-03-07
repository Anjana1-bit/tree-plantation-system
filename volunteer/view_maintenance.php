<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

$tree_id = $_GET['tree_id'];

$result = mysqli_query($conn,"
SELECT * FROM maintenance_records
WHERE tree_id='$tree_id'
ORDER BY maintenance_date DESC
");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Maintenance Records</h2>

<p class="text-muted mb-0">
View maintenance activities performed for this tree.
</p>

<hr>

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Activity</th>
<th>Date</th>
<th>Remarks</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>

<td><?php echo $row['maintenance_id']; ?></td>

<td><?php echo $row['activity_type']; ?></td>

<td><?php echo $row['maintenance_date']; ?></td>

<td><?php echo $row['remarks']; ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include('../includes/footer.php'); ?>