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
            ?>
        </head>
        <body class="theme-red">
            <?php
            include './menu.php';
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="block-header">
                        <h2>MONTHLY REPORT BASED ON BOOKING DATE (PAID BILTY)</h2>
                    </div>
                    <!-- Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>MONTH </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="month" onchange="getPrevEndNo();" class="form-control" name="gen_month" id="gen_month" placeholder="ENTER FROM DATE" />
                                                </div>
                                                <b class="text-danger" id="fdateErr"></b>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-info" onclick="paid_bilty_report();" >
                                                    SEARCH</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>MONTH START DDR NO </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="number" class="form-control" name="last_no" id="last_no" placeholder="ENTER MONTH START DDR NO" />
                                                </div>
                                                <b class="text-danger" id="tdateErr"></b>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="print_id" class="btn btn-primary" onclick="print_manifest('printableArea');" style="display:none;">
                                        PRINT 
                                    </button>
                                    <div id="result">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Input -->

                </div>
            </section>
            <?php
            include './footer_links.php';
            ?>
            <script>
                function print_manifest(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    window.location.href = "paid_bilty_report.php";
                }
            </script>
            <script>
                function paid_bilty_report() {
                    alert("gg");
                     var gen_month = $("#gen_month").val();
                    var last_no = $("#last_no").val();
                    if ((gen_month === "") || (last_no === "")) {
                        $("#result").html("");
                        $("#print_id").css("display", "none");
                        //alert("Provide fields");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?paid_bilty_report",
                            dataType: "json",
                            data: {
                              gen_month: gen_month,
                                last_no: last_no
                            },
                            success: function (RetVal) {
                                // document.getElementById("print_id").style.display:"block";
                                $("#print_id").css("display", "block");
                                $("#result").html(RetVal.data);

                            }
                        });
                    }
                }
                
                   function getPrevEndNo() {
                    var gen_month = $("#gen_month").val();
                    if (gen_month === "") {
                        $("#result").html("");
                        $("#print_id").css("display", "none");
                        //alert("Provide fields");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?ddr_pb",
                            dataType: "json",
                            data: {
                                gen_month: gen_month
                            },
                            success: function (RetVal) {
                                $("#last_no").val(RetVal.data);
                            }
                        });
                    }
                }
            </script>
        </body>
    </html>
    <?php
} else {
    header("location:index.php");
}
?>