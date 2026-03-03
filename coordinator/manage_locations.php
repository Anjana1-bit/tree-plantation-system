<?php
session_start();
include('../config/db_connect.php');

// Security check: Only allow coordinators
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header("Location: ../auth/login.php");
    exit();
}

// Handle Adding a New Location
if (isset($_POST['add_location'])) {
    $loc_name = mysqli_real_escape_string($conn, $_POST['location_name']);
    
    $insert_sql = "INSERT INTO locations (location_name) VALUES ('$loc_name')";
    if (mysqli_query($conn, $insert_sql)) {
        echo "<script>alert('Location added successfully!');</script>";
    }
}

// Fetch all locations to display in the table
$result = mysqli_query($conn, "SELECT * FROM locations ORDER BY location_id DESC");

// Include team components
include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-7">
            <h2 class="display-6">Planting Locations</h2>
            <p class="text-muted">View and expand the list of available sites for plantation events.</p>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title">Add New Location</h5>
                    <form method="POST" class="row g-2">
                        <div class="col-auto">
                            <input type="text" name="location_name" class="form-control" placeholder="e.g., Riverside Park" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="add_location" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Location Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row['location_id']; ?></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($row['location_name']); ?></td>
                            <td><span class="badge bg-primary">Available</span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-4">No locations found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>