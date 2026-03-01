<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn,
    "SELECT * FROM plantation_events WHERE event_id=$id"
);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $name = $_POST['event_name'];
    $date = $_POST['event_date'];
    $organized_by = $_POST['organized_by'];
    $total = $_POST['total_trees'];

    mysqli_query($conn,"
        UPDATE plantation_events SET
        event_name='$name',
        event_date='$date',
        organized_by='$organized_by',
        total_trees_planted='$total'
        WHERE event_id=$id
    ");

    header("Location: manage_events.php");
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="container mt-4">
    <h2>Edit Event</h2>

    <form method="POST">

        <input type="text" name="event_name"
               value="<?php echo $row['event_name']; ?>"
               class="form-control mb-3">

        <input type="date" name="event_date"
               value="<?php echo $row['event_date']; ?>"
               class="form-control mb-3">

        <input type="text" name="organized_by"
               value="<?php echo $row['organized_by']; ?>"
               class="form-control mb-3">

        <input type="number" name="total_trees"
               value="<?php echo $row['total_trees_planted']; ?>"
               class="form-control mb-3">

        <button type="submit" name="update"
                class="btn btn-primary">
                Update
        </button>

    </form>
</div>

<?php include('../includes/footer.php'); ?>