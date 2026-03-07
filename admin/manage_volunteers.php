<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM volunteers ORDER BY join_date DESC");

include('../includes/header.php');
include('../includes/navbar.php');
?>
<div class="container mt-4">
<div class="d-flex justify-content-between align-items-center mb-2">

<div>
<h2>Manage Volunteers</h2>

<p class="text-muted mb-0">
Add and manage volunteers who participate in plantation activities.
</p>

</div>

<a href="add_volunteer.php" class="btn btn-success">
<i class="fa fa-user-plus"></i> Add Volunteer
</a>

</div>

<hr>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Join Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['volunteer_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['join_date']; ?></td>
            <td>
                <a href="edit_volunteer.php?id=<?php echo $row['volunteer_id']; ?>"
                   class="btn btn-sm btn-primary">Edit</a>

                <a href="delete_volunteer.php?id=<?php echo $row['volunteer_id']; ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Are you sure?');">
                   Delete
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>
<?php include('../includes/footer.php'); ?>