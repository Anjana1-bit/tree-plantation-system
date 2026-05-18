<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// 🔐 Check login
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

// 🔐 Admin only
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

// 📌 Get ID
$id = $_GET['id'] ?? 0;

// ❌ If no ID
if($id == 0){
    header("Location: manage_coordinators.php");
    exit();
}

// 🔍 Step 1: Get coordinator name
$result = mysqli_query($conn, "
SELECT name 
FROM users 
WHERE user_id='$id' AND role='coordinator'
");

if(mysqli_num_rows($result) == 0){
    header("Location: manage_coordinators.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
$coordinator_name = $row['name'];

// 🔍 Step 2: Check if coordinator has events
$check = mysqli_query($conn, "
SELECT event_id 
FROM plantation_events 
WHERE organized_by='$coordinator_name'
");

// ❌ If events exist → block delete
if(mysqli_num_rows($check) > 0){

    echo "<script>
    alert('Cannot delete coordinator! Events are assigned.');
    window.location='manage_coordinators.php';
    </script>";
    exit();
}

// ✅ Step 3: Safe delete
mysqli_query($conn, "
DELETE FROM users 
WHERE user_id='$id' AND role='coordinator'
");

// ✅ Redirect
header("Location: manage_coordinators.php");
exit();
?>