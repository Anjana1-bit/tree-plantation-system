<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">

    <a class="navbar-brand" href="#">🌱 TPS</a>

    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <!-- ================= ADMIN ================= -->
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>

            <li class="nav-item">
                <a class="nav-link" href="../admin/dashboard.php">Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../admin/manage_volunteers.php">Volunteers</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../admin/manage_events.php">Events</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../admin/manage_trees.php">Trees</a>
            </li>

        <?php endif; ?>


        <!-- ================= COORDINATOR ================= -->
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'coordinator'): ?>

            <li class="nav-item">
                <a class="nav-link" href="../coordinator/dashboard.php">Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../coordinator/manage_locations.php">Manage Locations</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../coordinator/manage_events.php">Manage Events</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../coordinator/add_event.php">Add Event</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../coordinator/view_tree_status.php">Tree Status</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../coordinator/view_logs.php">Logs</a>
            </li>

        <?php endif; ?>


        <!-- ================= VOLUNTEER ================= -->
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'volunteer'): ?>

            <li class="nav-item">
                <a class="nav-link" href="../volunteer/dashboard.php">Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../volunteer/add_tree.php">Add Tree</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../volunteer/view_my_trees.php">My Trees</a>
            </li>

        <?php endif; ?>


        <!-- ================= LOGOUT ================= -->
        <?php if(isset($_SESSION['role'])): ?>
            <li class="nav-item">
                <a class="nav-link text-danger" href="../auth/logout.php">Logout</a>
            </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>