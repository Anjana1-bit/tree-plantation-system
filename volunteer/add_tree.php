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
<div class="d-flex justify-content-between align-items-center mb-2">

<div>

<h2>Add Tree</h2>

<p class="text-muted mb-0">
Record a newly planted tree under a plantation event.
</p>

</div>
</div>
<hr>

    <form method="POST">

        <input type="text" name="species"
               placeholder="Tree Species"
               class="form-control mb-3" required>

        <input type="date" name="plantation_date"
               class="form-control mb-3" required>

        <select name="event_id" class="form-control" required>

<option value="">Select Event</option>

<?php
$query = "
SELECT e.event_id, e.event_name, l.location_name
FROM plantation_events e
JOIN locations l ON e.location_id = l.location_id
";

$result = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){
?>

<option value="<?php echo $row['event_id']; ?>">

<?php echo $row['event_name']." - ".$row['location_name']; ?>

</option>

<?php } ?>

</select>

        <button type="submit" name="submit"
                class="btn btn-success">
                Add Tree
        </button>

    </form>
</div>
</div>
<?php include('../includes/footer.php'); ?>