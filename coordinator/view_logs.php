<?php
session_start();
include('../config/db_connect.php');

// Security: Redirect if not a coordinator
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coordinator') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch maintenance records for trees in events organized by THIS coordinator
$log_query = "SELECT m.*, t.species, v.name as vol_name 
              FROM maintenance_records m
              JOIN trees t ON m.tree_id = t.tree_id
              JOIN plantation_events e ON t.event_id = e.event_id
              LEFT JOIN volunteers v ON m.volunteer_id = v.volunteer_id
              WHERE e.organized_by = '$user_id'";
$log_result = mysqli_query($conn, $log_query);

// Include the standard team layout components
include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="display-6">Volunteer Maintenance Logs</h2>
            <p class="text-muted">Review maintenance activities performed on trees within your organized events.</p>
            <hr>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
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
                            <td class="fw-bold"><?php echo htmlspecialchars($log['species']); ?></td>
                            <td><?php echo htmlspecialchars($log['vol_name'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <?php echo htmlspecialchars($log['activity_type']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($log['maintenance_date']); ?></td>
                            <td><small class="text-muted"><?php echo htmlspecialchars($log['remarks'] ?? '-'); ?></small></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">No maintenance logs found for your events.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="index.php" class="btn btn-outline-secondary">Back to Dashboard</a>
    </div>
</div>

<?php 
// Include the shared footer
include('../includes/footer.php'); 
?>