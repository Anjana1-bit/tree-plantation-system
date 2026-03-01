<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM maintenance_records WHERE maintenance_id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $date = $_POST['maintenance_date'];
    $activity = $_POST['activity_type'];
    $remarks = $_POST['remarks'];

    mysqli_query($conn,"
        UPDATE maintenance_records SET
        maintenance_date='$date',
        activity_type='$activity',
        remarks='$remarks'
        WHERE maintenance_id=$id
    ");

    header("Location: manage_maintenance.php");
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="container mt-4">
    <h2>Edit Maintenance</h2>

    <form method="POST">
        <input type="date" name="maintenance_date"
               value="<?php echo $row['maintenance_date']; ?>"
               class="form-control mb-3">

        <input type="text" name="activity_type"
               value="<?php echo $row['activity_type']; ?>"
               class="form-control mb-3">

        <textarea name="remarks"
                  class="form-control mb-3"><?php echo $row['remarks']; ?></textarea>

        <button type="submit" name="update"
                class="btn btn-primary">Update</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>