<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn,
    "SELECT * FROM volunteers WHERE volunteer_id=$id"
);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $join_date = $_POST['join_date'];

    mysqli_query($conn,"
        UPDATE volunteers SET
        name='$name',
        email='$email',
        phone='$phone',
        join_date='$join_date'
        WHERE volunteer_id=$id
    ");

    header("Location: manage_volunteers.php");
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="container mt-4">
    <h2>Edit Volunteer</h2>

    <form method="POST">

        <input type="text" name="name"
               value="<?php echo $row['name']; ?>"
               class="form-control mb-3">

        <input type="email" name="email"
               value="<?php echo $row['email']; ?>"
               class="form-control mb-3">

        <input type="text" name="phone"
               value="<?php echo $row['phone']; ?>"
               class="form-control mb-3">

        <input type="date" name="join_date"
               value="<?php echo $row['join_date']; ?>"
               class="form-control mb-3">

        <button type="submit" name="update"
                class="btn btn-primary">
                Update
        </button>

    </form>
</div>

<?php include('../includes/footer.php'); ?>