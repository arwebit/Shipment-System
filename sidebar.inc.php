<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="home.php">
            <span class="align-middle"><?php echo $companyName; ?></span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item <?php echo $pageName === 'Dashboard' ? 'active' : '' ?>">
                <a class="sidebar-link" href="home.php">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

                <li class="sidebar-header">
                    Master
                </li>
                <li>
                <a class="sidebar-link" href="export_db.php">
                        <i class="align-middle" data-feather="database"></i> <span class="align-middle">Backup</span>
                    </a>

                </li>
                <li class="sidebar-item <?php echo $pageName === 'Manage Users' ? 'active' : '' ?>">
              <a class="sidebar-link" href="manage_users.php">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Users</span>
                    </a>
              </li>


            <li class="sidebar-header">
                Main
            </li>
            <li class="sidebar-item <?php echo $pageName === 'Manage Party' ? 'active' : '' ?>">
                <a class="sidebar-link" href="manage_party.php">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Party</span>
                </a>
            </li>
            <li class="sidebar-item <?php echo $pageName === 'Gatepass, Payment and Goods Entry' ? 'active' : '' ?>">
                <a class="sidebar-link" href="gatepass_payment_goods_entry.php">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Gatepass, Payment and Goods Entry</span>
                </a>
            </li>
            <li class="sidebar-header">
                Reports
            </li>
            <li class="sidebar-item <?php echo $pageName === 'Party Ledger Report' ? 'active' : '' ?>">
                <a class="sidebar-link" href="party_ledger_reports.php">
                    <i class="align-middle" data-feather="hash"></i> <span class="align-middle">Party Ledger Report</span>
                </a>
            </li>
            <li class="sidebar-item <?php echo $pageName === 'Company Ledger Report' ? 'active' : '' ?>">
                <a class="sidebar-link" href="ledger_reports.php">
                    <i class="align-middle" data-feather="hash"></i> <span class="align-middle">Company Ledger Report</span>
                </a>
            </li>

            <li class="sidebar-item <?php echo $pageName === 'Gatepass Report' ? 'active' : '' ?>">
                <a class="sidebar-link" href="gatepass_reports.php">
                    <i class="align-middle" data-feather="hash"></i> <span class="align-middle">Gatepass Report</span>
                </a>
            </li> <li class="sidebar-item <?php echo $pageName === 'Party Report' ? 'active' : '' ?>">
                <a class="sidebar-link" href="party_reports.php">
                    <i class="align-middle" data-feather="hash"></i> <span class="align-middle">Party Report</span>
                </a>
            </li>
            <li class="sidebar-header">
                Others
            </li>
            <li class="sidebar-item <?php echo $pageName === 'User Manual' ? 'active' : '' ?>">
                <a class="sidebar-link" href="user_manual.php">
                        <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Manual</span>
                    </a>
                </li>
        </ul>

    </div>
</nav>