<?php
$main_page = "Local shipment";
$page = "Monthly report";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
     if ($_REQUEST['destination_code']) {
     $dest_code = $_REQUEST['destination_code'];
     if($dest_code=="all"){
       $clause="";
     }else{
      $clause= "AND a.destination='$dest_code'";
     }
    
    ?>﻿
    <!DOCTYPE html>
    <html>
        <head>
            <?php
            include './header_links.php';

            include './footer_links.php';
            ?>
            <style type="text/css">
                @media print{
                    body{
                        size:A4;
                    }
                    table{
                        width: 800px;
                    }
                }
            </style>        
            <script type="text/javascript">
                function print_manifest(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    window.location.href = "gatepass_pending.php";
                }

            </script>
        </head>
        <body class="theme-red">
            <?php
            include './menu.php';
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="block-header">
                        <h2>PENDING GATE PASS</h2>
                    </div>
                    <!-- Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <button type="button" id="print_id" class="btn btn-primary" onclick="print_manifest('printableArea');">
                                        PRINT 
                                    </button>
                                    <div id="printableArea">
                                        <?php
                                        echo get_address();
                                        ?>
                                        <center><b>PENDING GATEPASS</b></center><br/>
                                        <table class="table table-hover" border="1" cellspacing="0" cellpadding="10">
                                            <thead>
                                                <tr>
                                                    <th>MANIFEST NO</th>
                                                    <th>MANIFEST DATE</th>
                                                    <th>BILTY NO</th>
                                                    <th>BOOKING CODE</th>
                                                    <th>BOOKING DATE</th>
                                                    <th>PARTY NAME</th>
                                                    <th>PACKET QUANTITY</th>
                                                    <th>COD / TO PAY AMOUNT (in &#8377;)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pending_gpSQL = "";
                                                $pending_gpSQL .= "SELECT * FROM despatch a LEFT JOIN gatepass b ON a.id=b.despatch_id INNER JOIN ";
                                                $pending_gpSQL .= "unload_shipment c ON c.id=a.unload_id INNER JOIN mas_private_mark d ON a.private_mark_id=d.id ";
                                                $pending_gpSQL .= "WHERE a.payment_status='C' $clause AND b.gatepass_id IS NULL ORDER BY c.manifest_date DESC";
                                                $pending_gpfetch = json_decode(ret_json_str($pending_gpSQL));
                                                foreach ($pending_gpfetch as $pending_gp_val) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $pending_gp_val->manifest_no; ?></td>
                                                        <td><?php echo date("d / m / Y", strtotime($pending_gp_val->manifest_date)); ?></td>
                                                        <td><?php echo $pending_gp_val->bilty_no; ?></td>
                                                        <td><?php echo $pending_gp_val->booking_code; ?></td>
                                                        <td><?php echo date("d / m / Y", strtotime($pending_gp_val->booking_date)); ?></td>
                                                        <td><?php echo $pending_gp_val->party_name; ?></td>
                                                        <td><?php echo $pending_gp_val->packet_quantity; 
                                                        if($pending_gp_val->packet_received>0){
                                                            echo "/". $pending_gp_val->packet_received;
                                                        }else{
                                                            echo "";
                                                        }
                                                        ?></td>
                                                        <td align="right"><?php echo $pending_gp_val->pay_cod_amt; ?></td>
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
                    <!-- #END# Input -->

                </div>
            </section>
        </body>
    </html>
    <?php
     }
} else {
    header("location:index.php");
}
?>