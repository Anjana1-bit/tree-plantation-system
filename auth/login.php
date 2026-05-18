<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tree Plantation And Monitoring System</title>

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
padding:15px;

/* Background */
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
width:100%;
max-width:360px;
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 20px 40px rgba(0,0,0,0.3);
text-align:center;
}

/* Title */
.login-card h3{
color:#2e7d32;
margin-bottom:5px;
font-weight:600;
}

/* Tagline */
.tagline{
font-size:13px;
color:#555;
margin-bottom:10px;
}

/* Subtitle */
.login-card p{
font-size:14px;
color:#777;
margin-bottom:20px;
}

/* Inputs */
.input-group-text{
background:white;
border-right:none;
}

.form-control{
border-left:none;
}

/* Button */
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

/* Forgot */
.forgot{
display:block;
margin-top:10px;
font-size:13px;
color:#333;
text-decoration:none;
}

.forgot:hover{
text-decoration:underline;
}

/* Footer */
.footer-text{
font-size:12px;
margin-top:15px;
color:#888;
}

/* Mobile tweaks */
@media (max-width:576px){
.login-card{
padding:20px;
}

h3{
font-size:18px;
}
}

</style>

</head>

<body>

<div class="login-card">

<h3>🌱Tree Plantation And Monitoring System</h3>

<div class="tagline">Monitor • Manage • Sustain</div>

<p><strong>Secure Login Portal</strong></p>

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


<!-- Role -->
<div class="mb-3">
<select name="role" class="form-control" required>
<option value="">Select Role</option>
<option value="admin">Admin</option>
<option value="coordinator">Coordinator</option>
<option value="volunteer">Volunteer</option>
</select>
</div>


<button class="login-btn">
Sign In
</button>

</form>

<a href="forgot_password.php" class="forgot">Forgot Password?</a>

<div class="footer-text">
© 2026 Tree Plantation Monitoring System
</div>

</div>

</body>
</html>