<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

if(isset($_POST['submit'])){

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$join_date = $_POST['join_date'];
$password = $_POST['password'];

/* Insert login data into users table */

mysqli_query($conn,"
INSERT INTO users(name,email,password,role)
VALUES('$name','$email','$password','volunteer')
");

/* Insert volunteer details */

mysqli_query($conn,"
INSERT INTO volunteers(name,email,phone,join_date)
VALUES('$name','$email','$phone','$join_date')
");

header("Location: manage_volunteers.php");
exit();

}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Add Volunteer</h2>

<p class="text-muted">
Create a volunteer who will participate in plantation activities.
</p>

<hr>

<form method="POST">

<div class="mb-3">
<label class="form-label">Volunteer Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Phone</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Join Date</label>
<input type="date" name="join_date" class="form-control" required>
</div>

<button type="submit" name="submit" class="btn btn-success">
<i class="fa fa-user-plus"></i> Add Volunteer
</button>

<a href="manage_volunteers.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

<?php include('../includes/footer.php'); ?>