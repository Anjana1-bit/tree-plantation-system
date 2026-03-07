<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

$volunteer_id = $_SESSION['user_id'];

/* Fetch trees planted by this volunteer */

$result = mysqli_query($conn,"
SELECT * FROM trees
WHERE volunteer_id='$volunteer_id'
ORDER BY plantation_date DESC
");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>My Trees</h2>

<p class="text-muted mb-0">
View and monitor the trees you have planted during plantation events.
</p>

<hr>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Species</th>
<th>Plantation Date</th>
<th>Status</th>
<th>Actions</th>
</tr>

</thead>

<tbody>

<?php while($tree = mysqli_fetch_assoc($result)): ?>

<tr>

<td><?php echo $tree['tree_id']; ?></td>

<td><?php echo $tree['species']; ?></td>

<td><?php echo $tree['plantation_date']; ?></td>

<td>

<?php
if($tree['survival_status'] == 'Alive'){
echo "<span class='badge bg-success'>Alive</span>";
}else{
echo "<span class='badge bg-danger'>Dead</span>";
}
?>

</td>

<td>

<a href="edit_tree.php?id=<?php echo $tree['tree_id']; ?>"
class="btn btn-sm btn-primary">
Edit
</a>

<a href="add_growth.php?tree_id=<?php echo $tree['tree_id']; ?>" 
class="btn btn-sm btn-success">
Add Growth
</a>

<a href="view_growth.php?tree_id=<?php echo $tree['tree_id']; ?>" 
class="btn btn-sm btn-info">
View Growth
</a>

<a href="add_maintenance.php?tree_id=<?php echo $tree['tree_id']; ?>" 
class="btn btn-sm btn-warning">
Add Maintenance
</a>

<a href="view_maintenance.php?tree_id=<?php echo $tree['tree_id']; ?>" 
class="btn btn-sm btn-secondary">
View Maintenance
</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include('../includes/footer.php'); ?>