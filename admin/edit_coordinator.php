<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// 🔐 Admin only
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'] ?? 0;

// ❌ Invalid ID
if($id == 0){
    header("Location: manage_coordinators.php");
    exit();
}

/* 🔍 Fetch coordinator */

$result = mysqli_query($conn,"
SELECT * FROM users
WHERE user_id='$id' AND role='coordinator'
");

if(mysqli_num_rows($result) == 0){
    header("Location: manage_coordinators.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

// 🔥 IMPORTANT: store old name
$old_name = $row['name'];

/* =========================
   UPDATE COORDINATOR
========================= */

if(isset($_POST['update'])){

    $new_name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ✅ Update coordinator
    mysqli_query($conn,"
    UPDATE users
    SET name='$new_name',
        email='$email',
        password='$password'
    WHERE user_id='$id'
    ");

    // 🔥 VERY IMPORTANT: update events also
    mysqli_query($conn,"
    UPDATE plantation_events
    SET organized_by='$new_name'
    WHERE organized_by='$old_name'
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
value="<?php echo htmlspecialchars($row['name']); ?>"
required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email"
class="form-control"
value="<?php echo htmlspecialchars($row['email']); ?>"
required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="text" name="password"
class="form-control"
value="<?php echo htmlspecialchars($row['password']); ?>"
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