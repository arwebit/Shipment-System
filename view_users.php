<?php
$main_page = "Admin";
$page = "View users";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
    ?>﻿
    <!DOCTYPE html>
    <html>

        <head>
            <?php
            include './header_links.php';
            ?>
        </head>

        <body class="theme-red">
            <?php
            include './menu.php';
            ?>
            <section class="content">
                <div class="container-fluid">
                    <div class="block-header">
                        <h2>VIEW USERS
                        </h2>
                    </div>
                    <!-- Basic Examples -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $user_SQL = "SELECT * FROM admin_login_access WHERE username!='admin'";
                                                $fetch_user = json_decode(ret_json_str($user_SQL));
                                                foreach ($fetch_user as $fetch_users) {
                                                    $role_id=$fetch_users->role;
                                                    if($role_id==1){
                                                        $role_name="Admin";
                                                    }elseif($role_id==2){
                                                       $role_name="Co-admin"; 
                                                    }else{
                                                        $role_name="User"; 
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $fetch_users->name; ?> </td>
                                                        <td><?php echo $fetch_users->username; ?></td>
                                                        <td><?php echo $fetch_users->password; ?></td>
                                                        <td><?php echo $role_name; ?></td>
                                                        <td><?php echo $fetch_users->status=="1"?"Active":"In-active"; ?></td>
                                                        <td>
                                                            <a href="edit_user.php?user_id=<?php echo $fetch_users->id; ?>" class="btn btn-info">
                                                            EDIT
                                                            </a>       
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Basic Examples -->
                </div>
            </section>
  <?php
       include './footer_links.php';
       ?>
        </body>

    </html>
    <?php
} else {
    header("location:index.php");
}
?>