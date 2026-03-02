<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// Volunteer Role Protection
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

$volunteer_id = $_SESSION['user_id'];

// Fetch only this volunteer's trees
$trees = mysqli_query($conn,
    "SELECT tree_id, species 
     FROM trees 
     WHERE volunteer_id = $volunteer_id"
);

if(isset($_POST['submit'])){

    $tree_id = $_POST['tree_id'];
    $maintenance_date = $_POST['maintenance_date'];
    $activity_type = $_POST['activity_type'];
    $remarks = $_POST['remarks'];

    mysqli_query($conn,"
        INSERT INTO maintenance_records
        (tree_id, volunteer_id, maintenance_date, activity_type, remarks)
        VALUES
        ('$tree_id', '$volunteer_id', '$maintenance_date', '$activity_type', '$remarks')
    ");

    header("Location: dashboard.php");
    exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Add Maintenance Record</h2>

    <form method="POST">

        <select name="tree_id" class="form-control mb-3" required>
            <option value="">Select Tree</option>
            <?php while($row = mysqli_fetch_assoc($trees)): ?>
                <option value="<?php echo $row['tree_id']; ?>">
                    <?php echo $row['species']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="date" name="maintenance_date"
               class="form-control mb-3" required>

        <input type="text" name="activity_type"
               placeholder="Activity Type (Watering, Fertilizing, etc.)"
               class="form-control mb-3" required>

        <textarea name="remarks"
                  placeholder="Remarks (optional)"
                  class="form-control mb-3"></textarea>

        <button type="submit" name="submit"
                class="btn btn-success">
                Add Maintenance
        </button>

    </form>
</div>

<?php include('../includes/footer.php'); ?>