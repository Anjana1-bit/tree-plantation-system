<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

if(isset($_POST['submit'])){

    $tree_id = $_POST['tree_id'];
    $volunteer_id = $_POST['volunteer_id'];
    $date = $_POST['maintenance_date'];
    $activity = $_POST['activity_type'];
    $remarks = $_POST['remarks'];

    mysqli_query($conn,"
        INSERT INTO maintenance_records
        (tree_id, volunteer_id, maintenance_date, activity_type, remarks)
        VALUES
        ('$tree_id','$volunteer_id','$date','$activity','$remarks')
    ");

    header("Location: manage_maintenance.php");
    exit();
}

$trees = mysqli_query($conn,"SELECT * FROM trees");
$volunteers = mysqli_query($conn,"SELECT * FROM volunteers");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Add Maintenance Record</h2>

    <form method="POST">

        <select name="tree_id" class="form-control mb-3" required>
            <option value="">Select Tree</option>
            <?php while($t = mysqli_fetch_assoc($trees)): ?>
                <option value="<?php echo $t['tree_id']; ?>">
                    <?php echo $t['species']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="volunteer_id" class="form-control mb-3" required>
            <option value="">Select Volunteer</option>
            <?php while($v = mysqli_fetch_assoc($volunteers)): ?>
                <option value="<?php echo $v['volunteer_id']; ?>">
                    <?php echo $v['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="date" name="maintenance_date" 
               class="form-control mb-3" required>

        <input type="text" name="activity_type" 
               placeholder="Activity Type" 
               class="form-control mb-3">

        <textarea name="remarks" 
                  class="form-control mb-3"
                  placeholder="Remarks"></textarea>

        <button type="submit" name="submit" 
                class="btn btn-success">Add Record</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>