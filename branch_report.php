<?php
$main_page = "Branch shipment";
$page = "Branch report ";
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
                        <h2>BRANCH REPORT</h2>
                    </div>
                    <!-- Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>SEARCH BY MANIFEST NO / LORRY NO / BRANCH NAME </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="branch_rep_cred" id="branch_rep_cred" placeholder="ENTER MANIFEST NO / LORRY NO / BRANCH NAME" onkeyup="branch_report(this.value);" />
                                                </div>
                                                <b class="text-danger" id="manifest_bilty_noErr"></b>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="print_id" class="btn btn-primary" onclick="print_branch('printableArea');" style="display:none;">
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
                function print_branch(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    window.location.href = "branch_report.php";
                }
            </script>
            <script>
                function branch_report(branch_rep_cred) {
                    if (branch_rep_cred === "") {
                        $("#result").html("");
                        $("#print_id").css("display", "none");
                       // alert("Provide fields");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?branch_report",
                            dataType: "json",
                            data: {
                                branch_rep_cred: branch_rep_cred
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
        </body>
    </html>
    <?php
} else {
    header("location:index.php");
}
?>