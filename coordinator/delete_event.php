<?php
session_start();
include('../config/db_connect.php');

// 1. Security Check: Only allow logged-in coordinators
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header("Location: ../auth/login.php");
    exit();
}

// 2. Check if an ID was passed in the URL
if (isset($_GET['id'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // 3. Delete logic: Ensure the coordinator can only delete THEIR OWN events
    // This matches your 'organized_by' column structure in the database
    $sql = "DELETE FROM plantation_events WHERE event_id = '$event_id' AND organized_by = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to manage_events with a success message
        echo "<script>alert('Event deleted successfully'); window.location='manage_events.php';</script>";
    } else {
        // Handle potential foreign key constraint errors
        echo "Error deleting event: " . mysqli_error($conn);
    }
} else {
    // If no ID is provided, just send them back
    header("Location: manage_events.php");
}
?>