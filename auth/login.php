<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tree Plantation Monitoring System</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
font-family:'Segoe UI',sans-serif;

/* Background Image */

background-image:url('../assets/images/tree.jpg');
background-size:cover;
background-position:center;
background-repeat:no-repeat;
}

/* Dark overlay */

body::before{
content:"";
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.45);
}

/* Login card */

.login-card{
position:relative;
width:360px;
background:white;
padding:35px;
border-radius:12px;
box-shadow:0 25px 50px rgba(0,0,0,0.3);
text-align:center;
}

/* Title */

.login-card h3{
color:#2e7d32;
margin-bottom:5px;
font-weight:600;
}

/* Subtitle */

.login-card p{
font-size:14px;
color:#777;
margin-bottom:25px;
}

/* Input styles */

.input-group-text{
background:white;
border-right:none;
}

.form-control{
border-left:none;
}

/* Login button */

.login-btn{
width:100%;
padding:10px;
background:#2e7d32;
border:none;
color:white;
border-radius:6px;
font-weight:500;
}

.login-btn:hover{
background:#1b5e20;
}

/* Footer */

.footer-text{
font-size:12px;
margin-top:15px;
color:#888;
}

</style>

</head>

<body>

<div class="login-card">

<h3>🌱 Tree Plantation Monitoring System</h3>

<p>User Login</p>

<form action="check_login.php" method="POST">

<div class="input-group mb-3">
<span class="input-group-text">
<i class="fa fa-envelope"></i>
</span>

<input type="email"
name="email"
class="form-control"
placeholder="Email Address"
required>

</div>


<div class="input-group mb-3">

<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>

<input type="password"
name="password"
class="form-control"
placeholder="Password"
required>

</div>


<button class="login-btn">
Login
</button>

</form>


<div class="footer-text">
© 2026 Tree Plantation Monitoring System
</div>

</div>

</body>
</html>