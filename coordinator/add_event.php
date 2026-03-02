<?php 
session_start();
include('../config/db_connect.php'); 
// Ensure only coordinators access this
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Add New Plantation Event</h2>
    <form action="process_event.php" method="POST">
        <label>Event Name:</label>
        <input type="text" name="event_name" required><br>

        <label>Event Date:</label>
        <input type="date" name="event_date" required><br>

        <label>Location:</label>
        <select name="location_id" required>
            <?php
            $locs = mysqli_query($conn, "SELECT * FROM locations");
            while($row = mysqli_fetch_assoc($locs)) {
                echo "<option value='".$row['location_id']."'>".$row['location_name']."</option>";
            }
            ?>
        </select><br>

        <button type="submit">Create Event</button>
    </form>
</body>
</html>