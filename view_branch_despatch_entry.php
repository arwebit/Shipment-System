<?php
$main_page = "Branch shipment";
$page = "View branch despatch entry";
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
                        <h2>VIEW BRANCH DESPATCH ENTRY</h2>
                    </div>
                    <!-- Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>SEARCH BY MANIFEST / BILTY NO </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="manifest_bilty_no" id="manifest_bilty_no" placeholder="ENTER MANIFEST / BILTY NO" onkeyup="search_despatch(this.value);" />
                                                </div>
                                                <b class="text-danger" id="manifest_bilty_noErr"></b>
                                            </div>
                                        </div>
                                    </div>
                                    <p id="result">

                                    </p>
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
                function search_despatch(manifest_bilty_no) {
                    if (manifest_bilty_no === "") {
                        $("#result").html("");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?search_branch_despatch",
                            dataType: "json",
                            data: {
                                manifest_bilty_no: manifest_bilty_no
                            },
                            success: function (RetVal) {
                           
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