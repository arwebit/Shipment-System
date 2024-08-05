<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="home.php">
            <span class="align-middle">Shipment Ledger</span>
        </a>

        <ul class="sidebar-nav">


            <li class="sidebar-item <?php echo $pageName === 'Dashboard' ? 'active' : '' ?>">
                <a class="sidebar-link" href="home.php">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <?php
if ($loginUserRole === "1") {
    ?>
                <li class="sidebar-header">
                    Master
                </li>
                <li class="sidebar-item <?php echo $pageName === 'Manage Users' ? 'active' : '' ?>">
                    <a class="sidebar-link" href="manage_users.php">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Users</span>
                    </a>
                </li>
            <?php
}?>

            <li class="sidebar-header">
                Others
            </li>
            <li class="sidebar-item <?php echo $pageName === 'Manage Party' ? 'active' : '' ?>">
                <a class="sidebar-link" href="manage_party.php">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Party</span>
                </a>
            </li>
        </ul>

    </div>
</nav>