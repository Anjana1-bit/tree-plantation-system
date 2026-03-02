<?php
session_start();
include('../config/db_connect.php');

// Security check: Only allow coordinators
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// SQL JOIN to get tree details linked to events organized by THIS coordinator
$query = "SELECT t.*, e.event_name, l.location_name 
          FROM trees t
          JOIN plantation_events e ON t.event_id = e.event_id
          JOIN locations l ON e.location_id = l.location_id
          WHERE e.organized_by = '$user_id'
          ORDER BY t.tree_id DESC";

$result = mysqli_query($conn, $query);

// Include the standard team layout components
include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="display-6 text-success">Tree Health & Status</h2>
            <p class="text-muted">Monitoring the survival and growth of trees from your events.</p>
            <hr>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Tree ID</th>
                        <th>Species</th>
                        <th>Event</th>
                        <th>Location</th>
                        <th>Current Status</th>
                        <th>Last Height</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row['tree_id']; ?></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($row['species']); ?></td>
                            <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['location_name']); ?></td>
                            <td>
                                <?php 
                                    $status = $row['status'] ?? 'Healthy';
                                    $badgeClass = ($status == 'Healthy') ? 'bg-success' : 'bg-warning text-dark';
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['height'] ?? '0'); ?> cm</td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">No trees recorded for your events yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
// Include the shared footer
include('../includes/footer.php'); 
?>