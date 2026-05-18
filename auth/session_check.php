<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ CHECK BOTH user_id AND role
if(!isset($_SESSION['user_id']) || !isset($_SESSION['role'])){
    header("Location: ../auth/login.php");
    exit();
}

?>