<?php
session_start();
include('../config/db_connect.php');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coordinator') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$log_query = "SELECT m.*, t.species, v.name as vol_name 
              FROM maintenance_records m
              JOIN trees t ON m.tree_id = t.tree_id
              JOIN plantation_events e ON t.event_id = e.event_id
              LEFT JOIN volunteers v ON m.volunteer_id = v.volunteer_id
              WHERE e.organized_by = '$user_id'";

$log_result = mysqli_query($conn, $log_query);

include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>

<div class="container my-5">
    <h2 class="mb-3">Volunteer Maintenance Logs</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Tree Species</th>
                        <th>Volunteer</th>
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Remarks</th>
                    </tr>
                </thead>

                <tbody>
                <?php if(mysqli_num_rows($log_result) > 0): ?>
                    <?php while($log = mysqli_fetch_assoc($log_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($log['species']); ?></td>
                            <td><?php echo htmlspecialchars($log['vol_name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($log['activity_type']); ?></td>
                            <td><?php echo htmlspecialchars($log['maintenance_date']); ?></td>
                            <td><?php echo htmlspecialchars($log['remarks'] ?? '-'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            No maintenance logs found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

    <div class="mt-4">
        <a href="dashboard.php" class="btn btn-outline-secondary">
            Back to Dashboard
        </a>
    </div>
</div>

<?php include('../includes/footer.php'); ?>