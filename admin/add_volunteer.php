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

    mysqli_query($conn,"
        INSERT INTO volunteers (name, email, phone, join_date)
        VALUES ('$name','$email','$phone','$join_date')
    ");

    header("Location: manage_volunteers.php");
    exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Add Volunteer</h2>

    <form method="POST">

        <input type="text" name="name"
               placeholder="Full Name"
               class="form-control mb-3" required>

        <input type="email" name="email"
               placeholder="Email"
               class="form-control mb-3">

        <input type="text" name="phone"
               placeholder="Phone"
               class="form-control mb-3">

        <input type="date" name="join_date"
               class="form-control mb-3">

        <button type="submit" name="submit"
                class="btn btn-success">
                Add Volunteer
        </button>

    </form>
</div>

<?php include('../includes/footer.php'); ?>