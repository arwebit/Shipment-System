<?php
$main_page = "Dashboard";
$page = "Dashboard";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $pend_gp_clase = "";
    $pending_gp_link = "gatepass_pending.php";

    $pend_gp_clase = "";
    $get_dest_code = "all";
    $local_gatepass_pendingSQL = "";
    $local_gatepass_pendingSQL .= "SELECT * FROM despatch a LEFT JOIN gatepass b ON a.id=b.despatch_id ";
    $local_gatepass_pendingSQL .= "WHERE a.payment_status='C' $pend_gp_clase  AND b.gatepass_id IS NULL";
    $local_gatepass_pending = connect_db()->countEntries($local_gatepass_pendingSQL);
    if ($local_gatepass_pending == 0) {
        $pending_gp_link = "#";
    } else {
        $pending_gp_link = "gatepass_pending.php?destination_code=$get_dest_code";
    }


    $login_user = $_SESSION['shipment_user'];
    $local_shipmentSQL = "SELECT * FROM unload_shipment";
    $local_shipment = connect_db()->countEntries($local_shipmentSQL);

    $local_despatchSQL = "SELECT * FROM despatch";
    $local_despatch = connect_db()->countEntries($local_despatchSQL);

    $local_gatepassSQL = "SELECT * FROM gatepass";
    $local_gatepass = connect_db()->countEntries($local_gatepassSQL);



    $branch_shipmentSQL = "SELECT * FROM branch_unload_shipment";
    $branch_shipment = connect_db()->countEntries($branch_shipmentSQL);

    $branch_despatchSQL = "SELECT * FROM branch_despatch";
    $branch_despatch = connect_db()->countEntries($branch_despatchSQL);
    ?>
    ﻿<!DOCTYPE html>
    <html>
        <head>
            <?php
            include './header_links.php';
            ?>
            <style>
                a.block_id{
                    text-decoration: none;
                }
            </style>
        </head>

        <body class="theme-red">
            <?php
            include './menu.php';
            ?>
            <section class="content">
                <div class="container-fluid">

                    <!-- LOCAL SHIPMENT -->
                    <div class="row clearfix">
                        <div class="block-header">
                            <h2>LOCAL SHIPMENT</h2>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a href="view_unload_shipment.php" class="block_id">
                                <div class="info-box bg-teal hover-expand-effect">
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="content">
                                        <div class="text">LOCAL SHIPMENT</div>
                                        <div class="number count-to" data-from="0" data-to="<?php echo $local_shipment; ?>" data-speed="15" data-fresh-interval="20">
                                            <?php echo $local_shipment; ?>
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a href="view_despatch_entry.php" class="block_id">
                                <div class="info-box bg-cyan hover-expand-effect">
                                    <div class="icon">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="content">
                                        <div class="text">LOCAL DESPATCH</div>
                                        <div class="number count-to" data-from="0" data-to="<?php echo $local_despatch; ?>" data-speed="15" data-fresh-interval="20">
                                            <?php echo $local_despatch; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a href="#" class="block_id">
                                <div class="info-box bg-light-green hover-expand-effect">
                                    <div class="icon">
                                        <i class="fa fa-archive"></i>
                                    </div>
                                    <div class="content">
                                        <div class="text">LOCAL GATEPASS</div>
                                        <div class="number count-to" data-from="0" data-to="<?php echo $local_gatepass; ?>" data-speed="1000" data-fresh-interval="20">
                                            <?php echo $local_gatepass; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a href="<?php echo $pending_gp_link; ?>" class="block_id" id="pending_gp_link">
                                <div class="info-box bg-pink hover-expand-effect">
                                    <div class="icon">
                                        <i class="fa fa-archive"></i>
                                    </div>
                                    <div class="content">
                                        <div class="text">GATEPASS PENDING</div>
                                        <div class="number count-to" data-from="0" data-to="<?php echo $local_gatepass_pending; ?>" data-speed="1000" data-fresh-interval="20">
                                            <span id="local_gatepass_pending"><?php echo $local_gatepass_pending; ?></span>
                                        </div>

                                    </div>

                                </div>
                            </a>
                            <select id="destination_code" class="form-control" data-live-search="true">
                                <option value="" style="margin-left: 35px;">SELECT DESTINATION CODE</option>
                                <?php
                                $destinationSQL = "";
                                $destinationSQL .= "SELECT a.destination FROM despatch a LEFT JOIN gatepass b ON a.id=b.despatch_id ";
                                $destinationSQL .= "WHERE a.payment_status='C' $pend_gp_clase  AND b.gatepass_id IS NULL GROUP BY a.destination";
                                $destinationfetch = json_decode(ret_json_str($destinationSQL));
                                foreach ($destinationfetch as $destinationVal) {
                                    ?>
                                    <option value="<?php echo $destinationVal->destination ?>" style="margin-left: 35px;">
                                        <?php echo $destinationVal->destination ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- LOCAL SHIPMENT -->
                    <!-- BRANCH SHIPMENT -->
                    <div class="row clearfix">
                        <div class="block-header">
                            <h2>BRANCH SHIPMENT</h2>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <a href="view_branch_unload_shipment.php" class="block_id">
                                <div class="info-box bg-teal hover-expand-effect">
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="content">
                                        <div class="text">BRANCH SHIPMENT</div>
                                        <div class="number count-to" data-from="0" data-to="<?php echo $branch_shipment; ?>" data-speed="15" data-fresh-interval="20">
                                            <?php echo $branch_shipment; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <a href="view_branch_despatch_entry.php" class="block_id">
                                <div class="info-box bg-cyan hover-expand-effect">
                                    <div class="icon">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="content">
                                        <div class="text">BRANCH DESPATCH</div>
                                        <div class="number count-to" data-from="0" data-to="<?php echo $branch_despatch; ?>" data-speed="15" data-fresh-interval="20">
                                            <?php echo $branch_despatch; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- BRANCH SHIPMENT -->
                </div>
            </section>

            <?php
            include './footer_links.php';
            ?>
            <script>
                $(document).ready(function () {

                    $("#destination_code").change(function () {
                        var destination_code = $(this).val();
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?dest_code",
                            dataType: "json",
                            data: {
                                destination_code: destination_code
                            },
                            success: function (RetVal) {
                                if (RetVal.message === "Success") {
                                    $("#local_gatepass_pending").text(RetVal.data);
                                    $("#pending_gp_link").attr("href", "");
                                    $("#pending_gp_link").attr("href", RetVal.link);
                                }
                            }
                        });
                    });
                });

            </script>
        </body>

    </html>
    <?php
} else {
    header("location:index.php");
}
?>