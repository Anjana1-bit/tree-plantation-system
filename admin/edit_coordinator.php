<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

/* Fetch coordinator data */

$result = mysqli_query($conn,"
SELECT * FROM users
WHERE user_id='$id' AND role='coordinator'
");

$row = mysqli_fetch_assoc($result);


/* Update coordinator */

if(isset($_POST['update'])){

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

mysqli_query($conn,"
UPDATE users
SET name='$name',
email='$email',
password='$password'
WHERE user_id='$id'
");

header("Location: manage_coordinators.php");
exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Edit Coordinator</h2>

<p class="text-muted">
Update coordinator information responsible for plantation activities.
</p>

<hr>

<form method="POST">

<div class="mb-3">
<label class="form-label">Coordinator Name</label>
<input type="text" name="name"
class="form-control"
value="<?php echo $row['name']; ?>"
required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email"
class="form-control"
value="<?php echo $row['email']; ?>"
required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="text" name="password"
class="form-control"
value="<?php echo $row['password']; ?>"
required>
</div>

<button type="submit" name="update" class="btn btn-primary">
Update Coordinator
</button>

<a href="manage_coordinators.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

<?php include('../includes/footer.php'); ?>