<?php
session_start();
include('../config/db_connect.php');

// Security check: Only allow coordinators
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator'){
    header("Location: ../auth/login.php");
    exit();
}

/* Add location */

if(isset($_POST['add_location'])){
    $loc_name = mysqli_real_escape_string($conn,$_POST['location_name']);

    mysqli_query($conn,"
    INSERT INTO locations(location_name)
    VALUES('$loc_name')
    ");
}

/* Fetch locations */

$result = mysqli_query($conn,"
SELECT * FROM locations
ORDER BY location_id DESC
");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-2">

<div>

<h2>Manage Locations</h2>

<p class="text-muted mb-0">
Add and manage plantation locations where events will be organized.
</p>

</div>

</div>

<hr>

<!-- Add Location Form -->

<form method="POST" class="mb-4 d-flex">

<input type="text"
name="location_name"
class="form-control me-2"
placeholder="Enter Location Name"
required>

<button type="submit"
name="add_location"
class="btn btn-success">

Add Location

</button>

</form>


<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Location Name</th>
<th>Status</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>

<td><?php echo $row['location_id']; ?></td>

<td><?php echo htmlspecialchars($row['location_name']); ?></td>

<td>
<span class="badge bg-success">
Available
</span>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include('../includes/footer.php'); ?>