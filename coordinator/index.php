<?php
session_start();
include('../config/db_connect.php');
$user_id = $_SESSION['user_id'];

// Fetch stats
$event_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM plantation_events WHERE organized_by = '$user_id'");
$event_count = mysqli_fetch_assoc($event_res)['count'];
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Coordinator Dashboard</h1>
    <div class="stats">
        <p>You have managed: <strong><?php echo $event_count; ?></strong> events.</p>
    </div>
    
    <nav>
        <a href="add_event.php">Add New Event</a> | 
        <a href="view_records.php">View Growth/Maintenance Records</a>
    </nav>
</body>
</html>