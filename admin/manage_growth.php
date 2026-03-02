<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$query = "
SELECT growth_records.*, trees.species 
FROM growth_records
LEFT JOIN trees 
ON growth_records.tree_id = trees.tree_id
ORDER BY measurement_date DESC
";

$result = mysqli_query($conn, $query);

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Manage Growth Records</h2>

   

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tree</th>
                <th>Measurement Date</th>
                <th>Height (cm)</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['growth_id']; ?></td>
            <td><?php echo $row['species']; ?></td>
            <td><?php echo $row['measurement_date']; ?></td>
            <td><?php echo $row['height_cm']; ?></td>
            <td>
                <a href="edit_growth.php?id=<?php echo $row['growth_id']; ?>" 
                   class="btn btn-sm btn-primary">Edit</a>

                <a href="delete_growth.php?id=<?php echo $row['growth_id']; ?>" 
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