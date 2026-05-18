<?php
session_start();
include('../config/db_connect.php');

// Avoid undefined errors
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

/* =========================
   ADMIN / COORDINATOR LOGIN
========================= */

if($role == 'admin' || $role == 'coordinator'){

    $query = "SELECT * FROM users 
              WHERE email='$email' 
              AND password='$password' 
              AND role='$role'";

    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        if($role == 'admin'){
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../coordinator/dashboard.php");
        }

        exit();
    }
}

/* =========================
   VOLUNTEER LOGIN (NO PASSWORD)
========================= */

if($role == 'volunteer'){

    $query = "SELECT * FROM volunteers WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['volunteer_id']; // unified session
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = 'volunteer';

        header("Location: ../volunteer/dashboard.php");
        exit();
    }
}

/* =========================
   INVALID LOGIN
========================= */

echo "<script>
alert('Invalid credentials or wrong role');
window.location='login.php';
</script>";
?>