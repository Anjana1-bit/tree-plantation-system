<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

/* Fetch tree details */

$result = mysqli_query($conn,"SELECT * FROM trees WHERE tree_id='$id'");
$row = mysqli_fetch_assoc($result);


/* Update tree */

if(isset($_POST['update'])){

$species = $_POST['species'];
$status = $_POST['survival_status'];

mysqli_query($conn,"
UPDATE trees
SET species='$species',
survival_status='$status'
WHERE tree_id='$id'
");

header("Location: view_my_trees.php");
exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Edit Tree</h2>

<p class="text-muted">
Update the tree details and survival status.
</p>

<hr>

<form method="POST">

<div class="mb-3">
<label class="form-label">Species</label>
<input type="text" name="species"
class="form-control"
value="<?php echo $row['species']; ?>"
required>
</div>

<div class="mb-3">
<label class="form-label">Survival Status</label>

<select name="survival_status" class="form-control">

<option value="Alive"
<?php if($row['survival_status']=='Alive') echo "selected"; ?>>
Alive
</option>

<option value="Dead"
<?php if($row['survival_status']=='Dead') echo "selected"; ?>>
Dead
</option>

</select>

</div>

<button type="submit" name="update" class="btn btn-primary">
Update Tree
</button>

<a href="view_my_trees.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

<?php include('../includes/footer.php'); ?>