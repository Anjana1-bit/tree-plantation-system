<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn,"
DELETE FROM users
WHERE user_id = '$id'
AND role='coordinator'
");

header("Location: manage_coordinators.php");
?>