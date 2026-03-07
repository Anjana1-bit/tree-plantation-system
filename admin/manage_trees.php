<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$query = "
SELECT trees.*, 
       plantation_events.event_name,
       volunteers.name AS volunteer_name
FROM trees
LEFT JOIN plantation_events 
    ON trees.event_id = plantation_events.event_id
LEFT JOIN volunteers
    ON trees.volunteer_id = volunteers.volunteer_id
";

$result = mysqli_query($conn, $query);

include('../includes/header.php');
include('../includes/navbar.php');
?>
<div class="container mt-4">
<div class="d-flex justify-content-between align-items-center mb-2">

<div>
<h2>Manage Trees</h2>

<p class="text-muted mb-0">
Add and manage trees planted during plantation events.
</p>
</div>

</div>
<hr>


    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Species</th>
                <th>Plantation Date</th>
                <th>Event</th>
                <th>Volunteer</th>
                <th>Status</th>
                <th>Height (cm)</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['tree_id']; ?></td>
            <td><?php echo $row['species']; ?></td>
            <td><?php echo $row['plantation_date']; ?></td>
            <td><?php echo $row['event_name']; ?></td>
            <td><?php echo $row['volunteer_name']; ?></td>
            <td><?php echo $row['survival_status']; ?></td>
            <td><?php echo $row['height_cm']; ?></td>
            <td>
                <a href="edit_tree.php?id=<?php echo $row['tree_id']; ?>" 
                   class="btn btn-sm btn-primary">Edit</a>

                <a href="delete_tree.php?id=<?php echo $row['tree_id']; ?>" 
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