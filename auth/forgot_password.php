<?php
include('../config/db_connect.php'); // DB connection
session_start();

$msg = "";

if(isset($_POST['reset'])){
    $email = $_POST['email'];
    $new_password = $_POST['password'];

    // Check if email exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0){

        // Update password
        $update = "UPDATE users SET password='$new_password' WHERE email='$email'";
        mysqli_query($conn, $update);

        $msg = "Password updated successfully!";
    } else {
        $msg = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:#f5f5f5;
font-family:'Segoe UI',sans-serif;
}

.card{
width:350px;
padding:25px;
border-radius:10px;
box-shadow:0 10px 25px rgba(0,0,0,0.2);
text-align:center;
}

h4{
color:#2e7d32;
margin-bottom:15px;
}

.msg{
margin-top:10px;
font-size:14px;
}
</style>
</head>

<body>

<div class="card">

<h4>🌱 Reset Password</h4>

<form method="POST">

<input type="email" name="email" class="form-control mb-3"
placeholder="Enter your email" required>

<input type="password" name="password" class="form-control mb-3"
placeholder="Enter new password" required>

<button name="reset" class="btn btn-success w-100">
Reset Password
</button>

</form>

<?php if($msg != "") echo "<div class='msg'>$msg</div>"; ?>

<a href="login.php" class="btn btn-link mt-2">Back to Login</a>

</div>

</body>
</html>