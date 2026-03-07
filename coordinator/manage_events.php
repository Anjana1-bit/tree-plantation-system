<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'coordinator'){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT 
e.event_id,
e.event_name,
e.event_date,
l.location_name,
COUNT(t.tree_id) AS plant_count

FROM plantation_events e

JOIN locations l 
ON e.location_id = l.location_id

LEFT JOIN trees t
ON t.event_id = e.event_id

WHERE e.organized_by = '$user_id'

GROUP BY e.event_id
";

$result = mysqli_query($conn,$query);

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-2">

<div>

<h2>Manage Events</h2>

<p class="text-muted mb-0">
Add and manage plantation events organized by you.
</p>

</div>

<a href="add_event.php" class="btn btn-success">
<i class="fa fa-plus"></i> Add Event
</a>

</div>

<hr>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>Event Name</th>
<th>Date</th>
<th>Location</th>
<th>Plants</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>

<td><?php echo $row['event_name']; ?></td>

<td><?php echo $row['event_date']; ?></td>

<td><?php echo $row['location_name']; ?></td>

<td>
<span class="badge bg-success">
<?php echo $row['plant_count']; ?>
</span>
</td>

<td>

<a href="delete_event.php?id=<?php echo $row['event_id']; ?>"
class="btn btn-sm btn-danger"
onclick="return confirm('Delete this event?')">

Delete

</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include('../includes/footer.php'); ?>