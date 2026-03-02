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
    $measurement_date = $_POST['measurement_date'];
    $height_cm = $_POST['height_cm'];

    mysqli_query($conn,"
        INSERT INTO growth_records
        (tree_id, measurement_date, height_cm)
        VALUES
        ('$tree_id', '$measurement_date', '$height_cm')
    ");

    // Optional: Update latest height in trees table
    mysqli_query($conn,"
        UPDATE trees
        SET height_cm = '$height_cm'
        WHERE tree_id = '$tree_id'
    ");

    header("Location: dashboard.php");
    exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Add Growth Record</h2>

    <form method="POST">

        <select name="tree_id" class="form-control mb-3" required>
            <option value="">Select Tree</option>
            <?php while($row = mysqli_fetch_assoc($trees)): ?>
                <option value="<?php echo $row['tree_id']; ?>">
                    <?php echo $row['species']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="date" name="measurement_date"
               class="form-control mb-3" required>

        <input type="number" name="height_cm"
               placeholder="Height (cm)"
               class="form-control mb-3" required>

        <button type="submit" name="submit"
                class="btn btn-success">
                Add Growth
        </button>

    </form>
</div>

<?php include('../includes/footer.php'); ?>