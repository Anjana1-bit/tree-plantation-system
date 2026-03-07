<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tree Plantation Monitoring System</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
height:100vh;
display:flex;
}

/* LEFT PANEL */

.left-section{
width:40%;
background:linear-gradient(135deg,#4CAF50,#66BB6A);
display:flex;
justify-content:center;
align-items:center;
flex-direction:column;
text-align:center;
color:white;
padding:40px;
}

.left-section img{
width:230px;
height:150px;
object-fit:cover;
border-radius:12px;
margin-bottom:20px;
box-shadow:0 12px 25px rgba(0,0,0,0.2);
}

.project-title{
font-size:34px;
font-weight:700;
letter-spacing:1px;
}

.tagline{
font-size:16px;
opacity:0.9;
}

/* RIGHT PANEL */

.right-section{
width:60%;
background:#f5f7fa;
display:flex;
justify-content:center;
align-items:center;
}

.login-card{
width:360px;
background:white;
padding:40px;
border-radius:16px;
box-shadow:0 25px 45px rgba(0,0,0,0.12);
}

.login-card h3{
text-align:center;
color:#2e7d32;
font-weight:600;
}

.login-card p{
text-align:center;
color:#888;
font-size:14px;
margin-bottom:25px;
}

.input-group-text{
background:white;
border-right:none;
}

.form-control{
border-left:none;
padding:12px;
}

.login-btn{
width:100%;
padding:12px;
border-radius:8px;
border:none;
background:#2e7d32;
color:white;
font-weight:600;
}

.login-btn:hover{
background:#1b5e20;
}

.footer-text{
text-align:center;
margin-top:15px;
font-size:13px;
color:#999;
}

</style>
</head>

<body>

<div class="left-section">

<img src="../assets/images/tree.jpg">

<h1 class="project-title">
🌿 Tree Plantation Monitoring System
</h1>

<p class="tagline">
Plant Today • Protect Tomorrow
</p>

</div>


<div class="right-section">

<div class="login-card">

<h3>User Login</h3>
<p>Access your dashboard</p>

<form action="check_login.php" method="POST">

<div class="input-group mb-3">
<span class="input-group-text">
<i class="fa fa-envelope"></i>
</span>
<input type="email" name="email" class="form-control" placeholder="Email Address" required>
</div>

<div class="input-group mb-3">
<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>
<input type="password" name="password" class="form-control" placeholder="Password" required>
</div>

<button type="submit" class="login-btn">
Login
</button>

</form>

<div class="footer-text">
© 2026 Tree Plantation Monitoring System
</div>

</div>

</div>

</body>
</html>