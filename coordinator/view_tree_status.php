<?php
session_start();
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator'){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Query to fetch trees with event, location and latest height */

$query = "
SELECT 
t.tree_id,
t.species,
t.survival_status,
e.event_name,
l.location_name,
MAX(g.height_cm) AS last_height

FROM trees t

JOIN plantation_events e 
ON t.event_id = e.event_id

JOIN locations l 
ON e.location_id = l.location_id

LEFT JOIN growth_records g 
ON g.tree_id = t.tree_id

WHERE e.organized_by = '$user_id'

GROUP BY t.tree_id

ORDER BY t.tree_id DESC
";

$result = mysqli_query($conn,$query);

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-2">

<div>

<h2>Tree Status</h2>

<p class="text-muted mb-0">
Monitor the survival and growth of trees planted during your events.
</p>

</div>

</div>

<hr>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>Tree ID</th>
<th>Species</th>
<th>Event</th>
<th>Location</th>
<th>Status</th>
<th>Last Height</th>
</tr>

</thead>

<tbody>

<?php if(mysqli_num_rows($result) > 0): ?>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>

<td><?php echo $row['tree_id']; ?></td>

<td><?php echo htmlspecialchars($row['species']); ?></td>

<td><?php echo htmlspecialchars($row['event_name']); ?></td>

<td><?php echo htmlspecialchars($row['location_name']); ?></td>

<td>

<?php
$status = $row['survival_status'];

if($status == 'Alive'){
    echo "<span class='badge bg-success'>Alive</span>";
}else{
    echo "<span class='badge bg-danger'>Dead</span>";
}
?>

</td>

<td>

<?php 
echo ($row['last_height']) 
? $row['last_height']." cm" 
: "No Record"; 
?>

</td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>

<td colspan="6" class="text-center">
No trees recorded for your events yet.
</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

<?php include('../includes/footer.php'); ?>