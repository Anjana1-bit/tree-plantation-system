<?php
include('../auth/session_check.php');
include('../config/db_connect.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer'){
    header("Location: ../auth/login.php");
    exit();
}

$tree_id = $_GET['tree_id'];

/* Fetch table data */
$result = mysqli_query($conn,"
SELECT * FROM growth_records
WHERE tree_id='$tree_id'
ORDER BY measurement_date DESC
");

/* Fetch graph data */
$graph = mysqli_query($conn,"
SELECT measurement_date, height_cm
FROM growth_records
WHERE tree_id='$tree_id'
ORDER BY measurement_date ASC
");

$dates = [];
$heights = [];
$i = 1;
while($g = mysqli_fetch_assoc($graph)){
    $dates[] = $g['measurement_date'];
    $heights[] = $g['height_cm'];
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-4">

<h2>Growth Records</h2>

<p class="text-muted mb-0">
View growth updates recorded for this tree.
</p>

<hr>

<!-- 📋 TABLE -->
<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>S.No</th>
<th>Height (cm)</th>
<th>Date</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>
<td><?php echo $i++; ?></td>
<td><?php echo $row['height_cm']; ?></td>
<td><?php echo $row['measurement_date']; ?></td>
</tr>

<?php endwhile; ?>

</tbody>

</table>

<!-- 📊 GRAPH -->
<div class="mt-5">

<h4 class="text-center">Growth Chart</h4>

<div style="max-width:700px; height:300px; margin:auto;">
    <canvas id="growthChart"></canvas>
</div>

<?php if(count($dates) == 0): ?>
<p class="text-muted text-center mt-2">No data available for graph.</p>
<?php endif; ?>

</div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = <?php echo json_encode($dates); ?>;
const data = <?php echo json_encode($heights); ?>;

new Chart(document.getElementById('growthChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Tree Height (cm)',
            data: data,
            borderWidth: 2,
            tension: 0.3,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // 🔥 keeps size fixed
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>

<?php include('../includes/footer.php'); ?>