<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM maintenance_records WHERE maintenance_id=$id");

header("Location: manage_maintenance.php");
exit();
?>