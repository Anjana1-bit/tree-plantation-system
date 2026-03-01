<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM trees WHERE tree_id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $species = $_POST['species'];
    $status = $_POST['survival_status'];
    $height = $_POST['height_cm'];

    mysqli_query($conn,"
        UPDATE trees SET
        species='$species',
        survival_status='$status',
        height_cm='$height'
        WHERE tree_id=$id
    ");

    header("Location: manage_trees.php");
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="container mt-4">
    <h2>Edit Tree</h2>

    <form method="POST">
        <input type="text" name="species" 
               value="<?php echo $row['species']; ?>" 
               class="form-control mb-3">

        <select name="survival_status" class="form-control mb-3">
            <option value="Alive">Alive</option>
            <option value="Dead">Dead</option>
        </select>

        <input type="number" name="height_cm" 
               value="<?php echo $row['height_cm']; ?>" 
               class="form-control mb-3">

        <button type="submit" name="update" 
                class="btn btn-primary">Update</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>