<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn,
    "DELETE FROM volunteers WHERE volunteer_id=$id"
);

header("Location: manage_volunteers.php");
exit();
?>