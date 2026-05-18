<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// 🔐 Admin check
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

// 📌 Get event ID safely
$id = $_GET['id'] ?? 0;

if($id == 0){
    header("Location: manage_events.php");
    exit();
}

/* =========================
   STEP 1: DELETE GROWTH RECORDS
========================= */
mysqli_query($conn,"
DELETE FROM growth_records
WHERE tree_id IN (
    SELECT tree_id FROM trees WHERE event_id='$id'
)
");

/* =========================
   STEP 2: DELETE MAINTENANCE RECORDS
========================= */
mysqli_query($conn,"
DELETE FROM maintenance_records
WHERE tree_id IN (
    SELECT tree_id FROM trees WHERE event_id='$id'
)
");

/* =========================
   STEP 3: DELETE TREES
========================= */
mysqli_query($conn,"
DELETE FROM trees
WHERE event_id='$id'
");

/* =========================
   STEP 4: DELETE EVENT
========================= */
mysqli_query($conn,"
DELETE FROM plantation_events
WHERE event_id='$id'
");

/* =========================
   REDIRECT
========================= */
header("Location: manage_events.php");
exit();
?>