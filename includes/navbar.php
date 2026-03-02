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

        <?php if(isset($_SESSION['role'])): ?>

        <!-- ================= ADMIN MENU ================= -->
        <?php if($_SESSION['role'] == 'admin'): ?>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/admin/dashboard.php">
                   Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/admin/manage_volunteers.php">
                   Volunteers
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/admin/manage_events.php">
                   Events
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/admin/manage_trees.php">
                   Trees
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/admin/manage_growth.php">
                   Growth
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/admin/manage_maintenance.php">
                   Maintenance
                </a>
            </li>
            <li class="nav-item">
    <a class="nav-link" href="view_tree_status.php">Status Log</a>
</li>

        <?php endif; ?>


        <!-- ================= COORDINATOR MENU ================= -->
        <?php if($_SESSION['role'] == 'coordinator'): ?>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/coordinator/dashboard.php">
                   Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/coordinator/manage_locations.php">
                   Locations
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/coordinator/manage_events.php">
                   Events
                </a>
            </li>

        <?php endif; ?>


        <!-- ================= VOLUNTEER MENU ================= -->
        <?php if($_SESSION['role'] == 'volunteer'): ?>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/volunteer/dashboard.php">
                   Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/volunteer/add_tree.php">
                   Add Tree
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/volunteer/add_growth.php">
                   Add Growth
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="/tree-plantation-system/volunteer/add_maintenance.php">
                   Maintenance
                </a>
            </li>

        <?php endif; ?>


        <!-- ================= LOGOUT ================= -->
        <li class="nav-item">
            <a class="nav-link text-danger"
               href="/tree-plantation-system/auth/logout.php">
               Logout
            </a>
        </li>

        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>