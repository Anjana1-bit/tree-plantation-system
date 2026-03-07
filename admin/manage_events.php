<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$query = "
SELECT plantation_events.*, locations.location_name
FROM plantation_events
LEFT JOIN locations
ON plantation_events.location_id = locations.location_id
ORDER BY event_date DESC
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
Add and manage plantation events organized by coordinators.
</p>
</div>
</div>

<hr>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Date</th>
                <th>Location</th>
                <th>Organized By</th>
                <th>Total Trees</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['event_id']; ?></td>
            <td><?php echo $row['event_name']; ?></td>
            <td><?php echo $row['event_date']; ?></td>
            <td><?php echo $row['location_name']; ?></td>
            <td><?php echo $row['organized_by']; ?></td>
            <td><?php echo $row['total_trees_planted']; ?></td>
            <td>
                <a href="edit_event.php?id=<?php echo $row['event_id']; ?>" 
                   class="btn btn-sm btn-primary">Edit</a>

                <a href="delete_event.php?id=<?php echo $row['event_id']; ?>" 
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
</div>
<?php include('../includes/footer.php'); ?>