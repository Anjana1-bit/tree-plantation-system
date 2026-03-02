<?php
session_start();
include('../config/db_connect.php');

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // In a real app, use password_verify()

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Save user data to the session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['city'] = $user['city'];

        // Redirect based on role
        if ($user['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] == 'coordinator') {
            header("Location: ../coordinator/dashboard.php");
        } else {
            header("Location: ../volunteer/dashboard.php");
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>