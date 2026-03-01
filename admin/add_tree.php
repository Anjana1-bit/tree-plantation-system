<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(isset($_POST['submit'])) {

    $species = $_POST['species'];
    $plantation_date = $_POST['plantation_date'];
    $event_id = $_POST['event_id'];
    $volunteer_id = $_POST['volunteer_id'];
    $survival_status = $_POST['survival_status'];
    $height_cm = $_POST['height_cm'];

    mysqli_query($conn, "
        INSERT INTO trees 
        (species, plantation_date, event_id, volunteer_id, survival_status, height_cm)
        VALUES 
        ('$species', '$plantation_date', '$event_id', '$volunteer_id', '$survival_status', '$height_cm')
    ");

    header("Location: manage_trees.php");
    exit();
}

$events = mysqli_query($conn, "SELECT * FROM plantation_events");
$volunteers = mysqli_query($conn, "SELECT * FROM volunteers");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Add Tree</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Species</label>
            <input type="text" name="species" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Plantation Date</label>
            <input type="date" name="plantation_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Event</label>
            <select name="event_id" class="form-control" required>
                <?php while($event = mysqli_fetch_assoc($events)): ?>
                    <option value="<?php echo $event['event_id']; ?>">
                        <?php echo $event['event_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Volunteer</label>
            <select name="volunteer_id" class="form-control" required>
                <?php while($vol = mysqli_fetch_assoc($volunteers)): ?>
                    <option value="<?php echo $vol['volunteer_id']; ?>">
                        <?php echo $vol['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Survival Status</label>
            <select name="survival_status" class="form-control">
                <option value="Alive">Alive</option>
                <option value="Dead">Dead</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Height (cm)</label>
            <input type="number" name="height_cm" class="form-control">
        </div>

        <button type="submit" name="submit" class="btn btn-success">
            Add Tree
        </button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>