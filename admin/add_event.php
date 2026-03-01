<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

if(isset($_POST['submit'])){

    $name = $_POST['event_name'];
    $date = $_POST['event_date'];
    $location_id = $_POST['location_id'];
    $organized_by = $_POST['organized_by'];
    $total = $_POST['total_trees'];

    mysqli_query($conn,"
        INSERT INTO plantation_events
        (event_name, event_date, location_id, organized_by, total_trees_planted)
        VALUES
        ('$name','$date','$location_id','$organized_by','$total')
    ");

    header("Location: manage_events.php");
    exit();
}

$locations = mysqli_query($conn,"SELECT * FROM locations");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Add Event</h2>

    <form method="POST">

        <input type="text" name="event_name"
               placeholder="Event Name"
               class="form-control mb-3" required>

        <input type="date" name="event_date"
               class="form-control mb-3" required>

        <select name="location_id"
                class="form-control mb-3" required>
            <option value="">Select Location</option>
            <?php while($loc = mysqli_fetch_assoc($locations)): ?>
                <option value="<?php echo $loc['location_id']; ?>">
                    <?php echo $loc['location_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="text" name="organized_by"
               placeholder="Organized By"
               class="form-control mb-3">

        <input type="number" name="total_trees"
               placeholder="Total Trees Planted"
               class="form-control mb-3">

        <button type="submit" name="submit"
                class="btn btn-success">
                Add Event
        </button>

    </form>
</div>

<?php include('../includes/footer.php'); ?>