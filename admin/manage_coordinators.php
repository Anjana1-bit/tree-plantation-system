<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// Allow only admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

// Fetch coordinators
$result = mysqli_query($conn, "SELECT * FROM users WHERE role='coordinator'");
$total = mysqli_num_rows($result);

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">

<div>
<h2>Manage Coordinators</h2>
<p class="text-muted mb-0">
Add and manage coordinators responsible for organizing plantation activities.
</p>
</div>

<a href="add_coordinator.php" class="btn btn-success mt-2 mt-md-0">
<i class="fa fa-user-plus"></i> Add Coordinator
</a>

</div>

<hr>

<p><strong>Total Coordinators: <?php echo $total; ?></strong></p>

<!-- ================= DESKTOP TABLE ================= -->
<div class="table-responsive d-none d-md-block">

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>S.No</th> <!-- 🔥 changed -->
<th>Name</th>
<th>Email</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php if($total > 0): ?>

<?php 
$i = 1;
mysqli_data_seek($result, 0); 
while($row = mysqli_fetch_assoc($result)): 
?>

<tr>

<td><?php echo $i++; ?></td> <!-- 🔥 serial number -->

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td>

<a href="edit_coordinator.php?id=<?php echo $row['user_id']; ?>" 
class="btn btn-sm btn-primary">
Edit
</a>

<?php if($row['email'] != $_SESSION['user']): ?>

<a href="delete_coordinator.php?id=<?php echo $row['user_id']; ?>" 
class="btn btn-sm btn-danger"
onclick="return confirm('Are you sure you want to delete this coordinator?');">
Delete
</a>

<?php else: ?>

<span class="text-muted">Not Allowed</span>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>
<td colspan="4" class="text-center">No coordinators found</td>
</tr>

<?php endif; ?>

</tbody>

</table>

</div>


<!-- ================= MOBILE CARD VIEW ================= -->
<div class="d-block d-md-none">

<?php if($total > 0): ?>

<?php 
$i = 1;
mysqli_data_seek($result, 0); 
while($row = mysqli_fetch_assoc($result)): 
?>

<div class="card mb-3 p-3">

<p><strong>S.No:</strong> <?php echo $i++; ?></p>

<p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>

<p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>

<div class="d-flex gap-2">

<a href="edit_coordinator.php?id=<?php echo $row['user_id']; ?>" 
class="btn btn-sm btn-primary w-50">
Edit
</a>

<?php if($row['email'] != $_SESSION['user']): ?>

<a href="delete_coordinator.php?id=<?php echo $row['user_id']; ?>" 
class="btn btn-sm btn-danger w-50"
onclick="return confirm('Are you sure?');">
Delete
</a>

<?php else: ?>

<span class="text-muted">Not Allowed</span>

<?php endif; ?>

</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p class="text-center">No coordinators found</p>

<?php endif; ?>

</div>

</div>

<?php include('../includes/footer.php'); ?>