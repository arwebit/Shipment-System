<?php
$main_page = "Local shipment";
$page = "Monthly report";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
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
                    window.location.href = "local_date_report.php";
                }

                function date_report() {
                    var fdate = $("#fdate").val();
                    var tdate = $("#tdate").val();
                    var type = $("#type").val();
                    var ddr_no = $("#ddr_no").val();
                    
                    if ((fdate === "") || (tdate === "")|| (ddr_no === "")) {
                        $("#result").html("");
                        $("#print_id").css("display", "none");
                        alert("Provide fields");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?local_date_report",
                            dataType: "json",
                            data: {
                                fdate: fdate,
                                tdate: tdate,
                                type:type,
                                ddr_no:ddr_no
                            },
                            success: function (RetVal) {
                                // document.getElementById("print_id").style.display:"block";
                                $("#print_id").css("display", "block");
                                $("#result").html(RetVal.data);

                            }
                        });
                    }
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
                        <h2>MONTHLY REPORT BASED ON DATE</h2>
                    </div>
                    <!-- Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>FROM </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="date" class="form-control" name="fdate" id="fdate" placeholder="ENTER FROM DATE" />
                                                </div>
                                                <b class="text-danger" id="fdateErr"></b>
                                            </div>
                                            <div class="form-group">
                                                <label>START DDR NO </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="ddr_no" id="ddr_no" placeholder="ENTER DDR NO" />
                                                </div>
                                                <b class="text-danger" id="fdateErr"></b>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-info" onclick="date_report();" >
                                                    SEARCH</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>TO </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="date" class="form-control" name="tdate" id="tdate" placeholder="ENTER FROM DATE" />
                                                </div>
                                                <b class="text-danger" id="fdateErr"></b>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                             <div class="form-group">
                                                <label>TYPE </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <select name="type" id="type" class="form-control" data-live-serach="true">
                                                        <option value="P">PAID</option>
                                                         <option value="C">TO PAY (GATEPASS)</option>
                                                    </select>
                                                </div>
                                                <b class="text-danger" id="fdateErr"></b>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="print_id" class="btn btn-primary" onclick="print_manifest('printableArea');" style="display:none;">
                                        PRINT 
                                    </button>
                                    <p id="result"></p>
                                    <h3 class="pag pag1"></h3>
                                    <div class="insert"></div>
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
} else {
    header("location:index.php");
}
?>