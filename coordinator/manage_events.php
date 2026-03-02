<?php
session_start();
include('../config/db_connect.php');

// Security check: only allow coordinators
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// SQL JOIN to get location names for the coordinator's specific events
$query = "SELECT e.*, l.location_name 
          FROM plantation_events e 
          JOIN locations l ON e.location_id = l.location_id 
          WHERE e.organized_by = '$user_id'";
$result = mysqli_query($conn, $query);

// Include the shared design components from your includes folder
include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>

<div class="container my-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="display-6">My Events & Locations</h2>
            <p class="text-muted">A record of plantation activities organized by you.</p>
        </div>
        <div class="col-auto">
            <a href="add_event.php" class="btn btn-success">Add New Event</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Plants</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                            <td><?php echo $row['location_name']; ?></td>
                            <td><span class="badge bg-success rounded-pill"><?php echo $row['total_trees_planted'] ?? 0; ?></span></td>
                            <td>
                                <a href="delete_event.php?id=<?php echo $row['event_id']; ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Delete this event?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">No events found. Start by creating your first event!</td>
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