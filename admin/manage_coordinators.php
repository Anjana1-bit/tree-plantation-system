<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE role='coordinator'");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-2">

<div>
<h2>Manage Coordinators</h2>

<p class="text-muted mb-0">
Add and manage coordinators responsible for organizing plantation activities.
</p>

</div>

<a href="add_coordinator.php" class="btn btn-success">
<i class="fa fa-user-plus"></i> Add Coordinator
</a>

</div>

<hr>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>

<td><?php echo $row['user_id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td>

<a href="edit_coordinator.php?id=<?php echo $row['user_id']; ?>" 
class="btn btn-sm btn-primary">
Edit
</a>

<a href="delete_coordinator.php?id=<?php echo $row['user_id']; ?>" 
class="btn btn-sm btn-danger"
onclick="return confirm('Are you sure?');">
Delete
</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include('../includes/footer.php'); ?>