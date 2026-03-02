<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$query = "
SELECT maintenance_records.*, 
       trees.species,
       volunteers.name AS volunteer_name
FROM maintenance_records
LEFT JOIN trees 
    ON maintenance_records.tree_id = trees.tree_id
LEFT JOIN volunteers
    ON maintenance_records.volunteer_id = volunteers.volunteer_id
ORDER BY maintenance_date DESC
";

$result = mysqli_query($conn, $query);

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Manage Maintenance Records</h2>



    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tree</th>
                <th>Volunteer</th>
                <th>Date</th>
                <th>Activity</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['maintenance_id']; ?></td>
            <td><?php echo $row['species']; ?></td>
            <td><?php echo $row['volunteer_name']; ?></td>
            <td><?php echo $row['maintenance_date']; ?></td>
            <td><?php echo $row['activity_type']; ?></td>
            <td><?php echo $row['remarks']; ?></td>
            <td>
                <a href="edit_maintenance.php?id=<?php echo $row['maintenance_id']; ?>" 
                   class="btn btn-sm btn-primary">Edit</a>

                <a href="delete_maintenance.php?id=<?php echo $row['maintenance_id']; ?>" 
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