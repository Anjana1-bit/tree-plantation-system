<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if($_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

// ✅ FIXED
$volunteer_id = $_SESSION['user_id'];

$result = mysqli_query($conn,"
SELECT * FROM trees
WHERE volunteer_id='$volunteer_id'
ORDER BY plantation_date DESC
");

include('../includes/header.php');
include('../includes/navbar.php');
?>

<style>

/* 📱 Mobile Responsive */
@media(max-width:768px){
    table thead{
        display:none;
    }

    table, table tbody, table tr, table td{
        display:block;
        width:100%;
    }

    table tr{
        background:#fff;
        margin-bottom:15px;
        border-radius:10px;
        padding:10px;
        box-shadow:0 2px 5px rgba(0,0,0,0.1);
    }

    table td{
        padding:8px;
        border:none;
    }

    table td::before{
        content: attr(data-label);
        font-weight:bold;
        display:block;
        color:#555;
        margin-bottom:5px;
    }

    .btn{
        margin:3px 2px;
        width:48%;
    }
}

</style>

<div class="container mt-4">

<h2>My Trees</h2>
<p class="text-muted">View and manage your planted trees.</p>

<hr>

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>S.No</th>
<th>Species</th>
<th>Date</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php $i = 1; while($tree = mysqli_fetch_assoc($result)): ?>

<tr>

<td data-label="S.No"><?php echo $i++; ?></td>

<td data-label="Species"><?php echo htmlspecialchars($tree['species']); ?></td>

<td data-label="Date"><?php echo $tree['plantation_date']; ?></td>

<td data-label="Status">
<?php
if($tree['survival_status'] == 'Alive'){
    echo "<span class='badge bg-success'>Alive</span>";
}else{
    echo "<span class='badge bg-danger'>Dead</span>";
}
?>
</td>

<td data-label="Actions">

<!-- EDIT -->
<?php if($tree['survival_status'] == 'Alive'): ?>
<a href="edit_tree.php?id=<?php echo $tree['tree_id']; ?>"
class="btn btn-sm btn-primary">Edit</a>
<?php else: ?>
<button class="btn btn-sm btn-secondary" disabled>Edit</button>
<?php endif; ?>


<!-- ADD GROWTH -->
<?php if($tree['survival_status'] == 'Alive'): ?>
<a href="add_growth.php?tree_id=<?php echo $tree['tree_id']; ?>"
class="btn btn-sm btn-success">+ Growth</a>
<?php else: ?>
<button class="btn btn-sm btn-secondary" disabled>+ Growth</button>
<?php endif; ?>


<!-- ADD MAINTENANCE -->
<?php if($tree['survival_status'] == 'Alive'): ?>
<a href="add_maintenance.php?tree_id=<?php echo $tree['tree_id']; ?>"
class="btn btn-sm btn-warning">+ Maintain</a>
<?php else: ?>
<button class="btn btn-sm btn-secondary" disabled>+ Maintain</button>
<?php endif; ?>


<!-- VIEW GROWTH -->
<a href="view_growth.php?tree_id=<?php echo $tree['tree_id']; ?>"
class="btn btn-sm btn-info">View Growth</a>


<!-- VIEW MAINTENANCE -->
<a href="view_maintenance.php?tree_id=<?php echo $tree['tree_id']; ?>"
class="btn btn-sm btn-dark">View Maintain</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include('../includes/footer.php'); ?>