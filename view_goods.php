<?php
$main_page = "Contents";
$page = "View contents";
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
                        <h2>VIEW CONTENTS
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
                                                    <th>Contents</th>
                                                    <th>Status</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cn_SQL = "SELECT * FROM mas_contents";
                                                $fetch_cn = json_decode(ret_json_str($cn_SQL));
                                                foreach ($fetch_cn as $fetch_cns) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $fetch_cns->contents_desc; ?></td>
                                                        <td><?php echo $fetch_cns->status=="1"?"Active":"In-active"; ?></td>
                                                        <td>
                                                            <a href="edit_contents.php?cn_id=<?php echo $fetch_cns->id; ?>" class="btn btn-info">
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