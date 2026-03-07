<?php 
session_start();
include('../config/db_connect.php'); 

// Only coordinators can access
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Add Plantation Event</h2>

<p class="text-muted">
Create a new plantation event by selecting a location and event date.
</p>

<hr>

<form action="process_event.php" method="POST">

<div class="mb-3">
<label class="form-label">Event Name</label>
<input type="text" name="event_name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Event Date</label>
<input type="date" name="event_date" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Location</label>

<select name="location_id" class="form-control" required>

<option value="">Select Location</option>

<?php
$locs = mysqli_query($conn, "SELECT * FROM locations");

while($row = mysqli_fetch_assoc($locs)){
echo "<option value='".$row['location_id']."'>".$row['location_name']."</option>";
}
?>

</select>

</div>

<button type="submit" class="btn btn-success">
<i class="fa fa-plus"></i> Create Event
</button>

<a href="manage_events.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

<?php include('../includes/footer.php'); ?>