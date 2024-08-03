<?php
$main_page = "Private mark";
$page = "View private mark";
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
                        <h2>VIEW PRIVATE MARK
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
                                                    <th>Private mark</th>
                                                    <th>Party name</th>
                                                    <th>GSTIN / Aadhar</th>
                                                    <th>Status</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pm_SQL = "SELECT * FROM mas_private_mark";
                                                $fetch_pm = json_decode(ret_json_str($pm_SQL));
                                                foreach ($fetch_pm as $fetch_pms) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $fetch_pms->private_mark; ?></td>
                                                        <td><?php echo $fetch_pms->party_name; ?></td>
                                                        <td><?php echo $fetch_pms->gstin_aadhar; ?> </td>
                                                        <td><?php echo $fetch_pms->status=="1"?"Active":"In-active"; ?></td>
                                                        <td>
                                                            <a href="edit_private_mark.php?pm_id=<?php echo $fetch_pms->id; ?>" class="btn btn-info">
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