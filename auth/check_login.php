<?php
session_start();
include('../config/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        // FIXED COLUMN NAME HERE
        $_SESSION['user_id'] = $user['user_id'];  
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if ($user['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } 
        elseif ($user['role'] == 'volunteer') {
            header("Location: ../volunteer/dashboard.php");
        } 
        elseif ($user['role'] == 'coordinator') {
            header("Location: ../coordinator/dashboard.php");
        }

        exit();

    } else {
        echo "<script>alert('Invalid Email or Password'); window.location='login.php';</script>";
        exit();
    }
}
?>