<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// Volunteer Role Protection
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

$volunteer_id = $_SESSION['user_id'];

$query = "
SELECT trees.*, plantation_events.event_name
FROM trees
LEFT JOIN plantation_events
ON trees.event_id = plantation_events.event_id
WHERE trees.volunteer_id = $volunteer_id
ORDER BY plantation_date DESC
";

$result = mysqli_query($conn, $query);

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>My Trees</h2>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Species</th>
                <th>Plantation Date</th>
                <th>Event</th>
                <th>Status</th>
                <th>Height (cm)</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['tree_id']; ?></td>
            <td><?php echo $row['species']; ?></td>
            <td><?php echo $row['plantation_date']; ?></td>
            <td><?php echo $row['event_name']; ?></td>
            <td>
                <?php if($row['survival_status'] == 'Alive'): ?>
                    <span class="text-success">Alive</span>
                <?php else: ?>
                    <span class="text-danger">Dead</span>
                <?php endif; ?>
            </td>
            <td><?php echo $row['height_cm']; ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>