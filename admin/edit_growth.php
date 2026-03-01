<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM growth_records WHERE growth_id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $date = $_POST['measurement_date'];
    $height = $_POST['height_cm'];

    mysqli_query($conn,"
        UPDATE growth_records SET
        measurement_date='$date',
        height_cm='$height'
        WHERE growth_id=$id
    ");

    header("Location: manage_growth.php");
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="container mt-4">
    <h2>Edit Growth Record</h2>

    <form method="POST">
        <input type="date" name="measurement_date" 
               value="<?php echo $row['measurement_date']; ?>" 
               class="form-control mb-3">

        <input type="number" name="height_cm" 
               value="<?php echo $row['height_cm']; ?>" 
               class="form-control mb-3">

        <button type="submit" name="update" 
                class="btn btn-primary">Update</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>