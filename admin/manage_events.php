<?php
session_start();
include('../config/db_connect.php');

// 🔐 Check login
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

// 🔐 Admin only
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

// ✅ UPDATED QUERY (JOIN users + locations + trees)
$query = "
SELECT 
    plantation_events.*, 
    locations.location_name,
    users.name AS organizer_name,
    COUNT(trees.tree_id) AS total_trees
FROM plantation_events
LEFT JOIN locations 
    ON plantation_events.location_id = locations.location_id
LEFT JOIN users
    ON plantation_events.organized_by = users.user_id
LEFT JOIN trees 
    ON plantation_events.event_id = trees.event_id
GROUP BY plantation_events.event_id
ORDER BY plantation_events.event_date DESC
";

$result = mysqli_query($conn, $query);

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-2">

<div>
<h2>Manage Events</h2>
<p class="text-muted mb-0">
View and manage plantation events.
</p>
</div>

</div>

<hr>

<!-- ================= DESKTOP TABLE ================= -->
<div class="table-responsive d-none d-md-block">

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Event Name</th>
<th>Date</th>
<th>Location</th>
<th>Organizer</th>
<th>Total Trees</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($result) > 0): ?>
<?php mysqli_data_seek($result,0); while($row = mysqli_fetch_assoc($result)): ?>

<tr>

<td><?php echo $row['event_id']; ?></td>
<td><?php echo htmlspecialchars($row['event_name']); ?></td>
<td><?php echo $row['event_date']; ?></td>
<td><?php echo htmlspecialchars($row['location_name']); ?></td>

<!-- ✅ FIXED ORGANIZER -->
<td><?php echo htmlspecialchars($row['organizer_name']); ?></td>

<td><?php echo $row['total_trees']; ?></td>

<td>

<a href="edit_event.php?id=<?php echo $row['event_id']; ?>" 
class="btn btn-sm btn-primary">Edit</a>

<a href="delete_event.php?id=<?php echo $row['event_id']; ?>" 
class="btn btn-sm btn-danger"
onclick="return confirm('Are you sure you want to delete this event?');">
Delete
</a>

</td>

</tr>

<?php endwhile; ?>
<?php else: ?>

<tr>
<td colspan="7" class="text-center">No events found</td>
</tr>

<?php endif; ?>

</tbody>

</table>

</div>


<!-- ================= MOBILE CARD VIEW ================= -->
<div class="d-block d-md-none">

<?php if(mysqli_num_rows($result) > 0): ?>
<?php mysqli_data_seek($result,0); while($row = mysqli_fetch_assoc($result)): ?>

<div class="card mb-3 p-3 shadow-sm">

<h6 class="text-muted">Event Details</h6>

<p class="mb-1"><strong>ID:</strong> <?php echo $row['event_id']; ?></p>

<p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($row['event_name']); ?></p>

<p class="mb-1"><strong>Date:</strong> <?php echo $row['event_date']; ?></p>

<p class="mb-1"><strong>Location:</strong> <?php echo htmlspecialchars($row['location_name']); ?></p>

<!-- ✅ FIXED ORGANIZER -->
<p class="mb-1"><strong>Organizer:</strong> <?php echo htmlspecialchars($row['organizer_name']); ?></p>

<p class="mb-2"><strong>Total Trees:</strong> <?php echo $row['total_trees']; ?></p>

<hr>

<div class="d-flex gap-2">

<a href="edit_event.php?id=<?php echo $row['event_id']; ?>" 
class="btn btn-sm btn-primary w-50">Edit</a>

<a href="delete_event.php?id=<?php echo $row['event_id']; ?>" 
class="btn btn-sm btn-danger w-50"
onclick="return confirm('Are you sure?');">
Delete
</a>

</div>

</div>

<?php endwhile; ?>
<?php else: ?>

<p class="text-center">No events found</p>

<?php endif; ?>

</div>

</div>

<?php include('../includes/footer.php'); ?>