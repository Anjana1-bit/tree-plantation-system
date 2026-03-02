<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$query = "
SELECT tree_status_log.*, trees.species
FROM tree_status_log
LEFT JOIN trees
ON tree_status_log.tree_id = trees.tree_id
ORDER BY change_date DESC
";

$result = mysqli_query($conn, $query);

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Tree Status Change History</h2>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Tree ID</th>
                <th>Species</th>
                <th>Old Status</th>
                <th>New Status</th>
                <th>Changed On</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['tree_id']; ?></td>
                <td><?php echo $row['species']; ?></td>
                <td class="text-warning"><?php echo $row['old_status']; ?></td>
                <td class="text-success"><?php echo $row['new_status']; ?></td>
                <td><?php echo $row['change_date']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>