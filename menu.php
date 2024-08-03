<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<!--  <div class="search-bar">
      <div class="search-icon">
          <i class="material-icons">search</i>
      </div>
      <input type="text" placeholder="START TYPING...">
      <div class="close-search">
          <i class="material-icons">close</i>
      </div>
  </div>-->
<!-- #END# Search Bar -->
<!---TOP BAR -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="home.php"><?php echo getCompanyName(); ?></a>
        </div>
    </div>
</nav>
<!---TOP BAR -->

<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="images/user.png" width="48" height="48" alt="User" />
            </div>
            <?php
            $loginuser_SQL = "SELECT * FROM admin_login_access WHERE username='$login_user'";
            $fetch_loginuser = json_decode(ret_json_str($loginuser_SQL));
            foreach ($fetch_loginuser as $fetch_loginusers) {
                $login_role_id = $fetch_loginusers->role;
                if ($login_role_id == 1) {
                    $login_role_name = "Admin";
                } elseif ($login_role_id == 2) {
                    $login_role_name = "Co-admin";
                } else {
                    $login_role_name = "User";
                }
            }
            ?>
            <div class="info-container" style="color: #FFFFFF;">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <b><?php echo $fetch_loginusers->name; ?></b></div>
                <h5>Role : <?php echo $login_role_name; ?></h5>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="<?php if ($main_page == "Dashboard") { ?> active <?php } ?>">
                    <a href="home.php">
                        <i class="fa fa-home fa-2x"></i>
                        <span>Home</span>
                    </a>
                </li>
                  <li>
                    <a href="export_db.php">
                        <i class="fa fa-cart-plus fa-2x"></i>
                        <span>Backup</span>
                    </a>
                </li>
                <?php
                if ($login_user != "admin") {
                    ?>
                    <li class="<?php if ($main_page == "Change password") { ?> active <?php } ?>">
                        <a href="change_password.php">
                            <i class="fa fa-lock fa-2x"></i>
                            <span>Change password</span>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php
                //if (($login_role_id == "1") || ($login_role_id == "2")) {
                    ?>
                    <!--<li class="<?php //if ($main_page == "Admin") { ?> active <?php //} ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-gear fa-2x"></i>
                            <span>Admin settings</span>
                        </a>
                        <ul class="ml-menu">
                            <?php
                           // if ($login_role_id == "1") {
                                ?>
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <span>Users</span>
                                    </a>
                                    <ul class="ml-menu">
                                        <li>
                                            <a href="add_users.php">Add</a>
                                        </li>
                                        <li>
                                            <a href="view_users.php">View / Edit </a>
                                        </li>
                                    </ul>
                                </li>
                                <?php
                         //   }
                            ?>

                        </ul>
                    </li>-->
                    <?php
                //}
                ?>

                <li class="<?php if ($main_page == "Private mark") { ?> active <?php } ?>">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="fa fa-file-text fa-2x"></i>
                        <span>Private mark</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="add_private_mark.php">Add</a>
                        </li>
                        <li>
                            <a href="view_private_mark.php">View / Edit </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php if ($main_page == "Contents") { ?> active <?php } ?>">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="fa fa-file-text fa-2x"></i>
                        <span>Contents</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="add_goods.php">Add</a>
                        </li>
                        <li>
                            <a href="view_goods.php">View / Edit </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php if ($main_page == "Local shipment") { ?> active <?php } ?>">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="fa fa-cart-plus fa-2x"></i>
                        <span>Local Shipment and Despatch</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="add_unload_shipment.php">
                                <span>Add unload shipment</span></a> </li>
                        <li>
                            <a href="view_unload_shipment.php">
                                <span>View unload shipment / Despatch Entry</span></a> </li>
                        <li>
                            <a href="view_despatch_entry.php">
                                <span>View Despatch Entry and apply for gate pass</span></a> </li>
                        <li>
                            <a href="generate_gatepass.php">
                                <span>Generate gate pass</span></a> </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Reports</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="monthly_report.php">
                                        <span>Monthly gatepass report</span></a> </li>
                                        <li>
                                            <a href="paid_bilty_report.php">
                                        <span>Monthly paid bilty report</span></a> </li>
                                <li>
                                    <a href="manifest_no_report.php">
                                        <span>By manifest no</span></a> </li>
                                        <li>
                                    <a href="bilty_no_report.php">
                                        <span>By bilty no</span></a> </li>
                                        <li>
                                    <a href="local_date_report.php">
                                        <span>By date</span></a> </li>
                            </ul>
                        </li>
                    </ul>
                </li>


                <li class="<?php if ($main_page == "Branch shipment") { ?> active <?php } ?>">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="fa fa-cart-plus fa-2x"></i>
                        <span>Branch Shipment and Despatch</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="add_branch_unload_shipment.php">
                                <span>Add unload shipment</span></a> </li>
                        <li>
                            <a href="view_branch_unload_shipment.php">
                                <span>View unload shipment / Despatch Entry</span></a> </li>
                        <li>
                            <a href="view_branch_despatch_entry.php">
                                <span>View Despatch Entry</span></a> </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Reports</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="branch_report.php">
                                        <span>Branch report</span></a> </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fa fa-sign-out fa-2x"></i>
                        <span>Sign out</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2021 - 2022 <a href="#">Amarjyoti Roadlink</a>.
            </div>

        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>