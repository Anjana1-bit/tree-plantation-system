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
$password = $_POST['password'];

/* Insert coordinator */

mysqli_query($conn,"
INSERT INTO users(name,email,password,role)
VALUES('$name','$email','$password','coordinator')
");

header("Location: manage_coordinators.php");
exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<div class="mb-4">
<h2>Add Coordinator</h2>
<p class="text-muted">
Create a new coordinator account responsible for managing plantation events.
</p>
</div>

<div class="card shadow-sm p-4" style="max-width:500px">

<form method="POST">

<div class="mb-3">
<label class="form-label">Coordinator Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" name="submit" class="btn btn-success">
Add Coordinator
</button>

<a href="manage_coordinators.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</div>

<?php include('../includes/footer.php'); ?>