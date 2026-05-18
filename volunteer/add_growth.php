<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

/* ================= ROLE CHECK ================= */
if($_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

/* ================= SESSION ================= */
$volunteer_id = $_SESSION['user_id'];

/* ================= GET TREE ================= */
if(!isset($_GET['tree_id'])){
    die("No tree selected");
}

$tree_id = $_GET['tree_id'];

/* ================= VALIDATE TREE ================= */
$tree_check = mysqli_query($conn,"
SELECT species, survival_status 
FROM trees
WHERE tree_id='$tree_id' AND volunteer_id='$volunteer_id'
");

if(mysqli_num_rows($tree_check) == 0){
    die("Invalid tree or not your tree");
}

$tree = mysqli_fetch_assoc($tree_check);

/* ================= BLOCK DEAD TREE ================= */
if($tree['survival_status'] == 'Dead'){
    echo "<script>
            alert('Cannot add growth to dead tree');
            window.location='view_my_trees.php';
          </script>";
    exit();
}

/* ================= LAST GROWTH ================= */
$last_growth = mysqli_query($conn,"
SELECT measurement_date, height_cm 
FROM growth_records
WHERE tree_id='$tree_id'
ORDER BY measurement_date DESC
LIMIT 1
");

$last_data = mysqli_fetch_assoc($last_growth);

/* ================= SUBMIT ================= */
if(isset($_POST['submit'])){

    $measurement_date = $_POST['measurement_date'];
    $height_cm = $_POST['height_cm'];

    /* ❌ NEGATIVE HEIGHT */
    if($height_cm <= 0){

        mysqli_query($conn,"
        UPDATE trees SET survival_status='Dead'
        WHERE tree_id='$tree_id'
        ");

        echo "<script>
                alert('Tree marked as DEAD');
                window.location='view_my_trees.php';
              </script>";
        exit();
    }

    if($last_data){

        /* ❌ SAME / OLD DATE NOT ALLOWED */
        if($measurement_date <= $last_data['measurement_date']){
            echo "<script>alert('Date must be after last entry');</script>";
        }

        /* ❌ HEIGHT DECREASE */
        elseif($height_cm < $last_data['height_cm']){
            echo "<script>alert('Height cannot decrease');</script>";
        }

        else{

            mysqli_query($conn,"
            INSERT INTO growth_records(tree_id, measurement_date, height_cm)
            VALUES('$tree_id','$measurement_date','$height_cm')
            ");

            mysqli_query($conn,"
            UPDATE trees SET height_cm='$height_cm'
            WHERE tree_id='$tree_id'
            ");

            echo "<script>
                    alert('Growth added successfully');
                    window.location='view_growth.php?tree_id=$tree_id';
                  </script>";
            exit();
        }

    } else {

        mysqli_query($conn,"
        INSERT INTO growth_records(tree_id, measurement_date, height_cm)
        VALUES('$tree_id','$measurement_date','$height_cm')
        ");

        mysqli_query($conn,"
        UPDATE trees SET height_cm='$height_cm'
        WHERE tree_id='$tree_id'
        ");

        echo "<script>
                alert('Growth added successfully');
                window.location='view_growth.php?tree_id=$tree_id';
              </script>";
        exit();
    }
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Add Growth</h2>

<p class="text-muted">
Tree: <strong><?php echo htmlspecialchars($tree['species']); ?></strong>
</p>

<!-- LAST UPDATE -->
<?php if($last_data): ?>
<div class="alert alert-info">
<strong>Last Update:</strong><br>
Date: <?php echo $last_data['measurement_date']; ?><br>
Height: <?php echo $last_data['height_cm']; ?> cm
</div>
<?php else: ?>
<div class="alert alert-warning">
No previous growth record found.
</div>
<?php endif; ?>

<hr>

<form method="POST">

<div class="mb-3">
<label>Measurement Date</label>
<input type="date" name="measurement_date"
class="form-control"
min="<?php echo $last_data ? $last_data['measurement_date'] : ''; ?>"
required>
</div>

<div class="mb-3">
<label>Height (cm)</label>
<input type="number" name="height_cm"
class="form-control"
min="1"
required>
</div>

<button type="submit" name="submit" class="btn btn-success">
Add Growth
</button>

<a href="view_my_trees.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

<?php include('../includes/footer.php'); ?>