<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

// Volunteer Role Protection
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

$volunteer_id = $_SESSION['user_id'];

// Fetch events for dropdown
$events = mysqli_query($conn, "SELECT * FROM plantation_events ORDER BY event_date DESC");

if(isset($_POST['submit'])){

    $species = $_POST['species'];
    $plantation_date = $_POST['plantation_date'];
    $event_id = $_POST['event_id'];

    mysqli_query($conn,"
        INSERT INTO trees
        (species, plantation_date, event_id, volunteer_id)
        VALUES
        ('$species', '$plantation_date', '$event_id', '$volunteer_id')
    ");

    header("Location: dashboard.php");
    exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">
    <h2>Add Tree</h2>

    <form method="POST">

        <input type="text" name="species"
               placeholder="Tree Species"
               class="form-control mb-3" required>

        <input type="date" name="plantation_date"
               class="form-control mb-3" required>

        <select name="event_id" class="form-control mb-3" required>
            <option value="">Select Event</option>
            <?php while($row = mysqli_fetch_assoc($events)): ?>
                <option value="<?php echo $row['event_id']; ?>">
                    <?php echo $row['event_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="submit"
                class="btn btn-success">
                Add Tree
        </button>

    </form>
</div>

<?php include('../includes/footer.php'); ?>