<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(isset($_POST['submit'])) {

    $tree_id = $_POST['tree_id'];
    $measurement_date = $_POST['measurement_date'];
    $height_cm = $_POST['height_cm'];

    mysqli_query($conn, "
        INSERT INTO growth_records 
        (tree_id, measurement_date, height_cm)
        VALUES 
        ('$tree_id', '$measurement_date', '$height_cm')
    ");

    header("Location: manage_growth.php");
    exit();
}

$trees = mysqli_query($conn, "SELECT * FROM trees");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Add Growth Record</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Select Tree</label>
            <select name="tree_id" class="form-control" required>
                <?php while($tree = mysqli_fetch_assoc($trees)): ?>
                    <option value="<?php echo $tree['tree_id']; ?>">
                        <?php echo $tree['species']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Measurement Date</label>
            <input type="date" name="measurement_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Height (cm)</label>
            <input type="number" name="height_cm" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-success">
            Add Record
        </button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>