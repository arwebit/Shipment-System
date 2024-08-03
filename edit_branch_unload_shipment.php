<?php
$main_page = "Branch shipment";
$page = "Edit branch unload shipment";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
    if ($_GET['branch_ship_id']) {
        $branch_ship_id = $_GET['branch_ship_id'];
        $manifestSQL = "SELECT * FROM branch_unload_shipment WHERE id='$branch_ship_id'";
        $manifest_fetch = json_decode(ret_json_str($manifestSQL));
        foreach ($manifest_fetch as $manifest_val) {
            $source_manifest_no = $manifest_val->source_manifest_no;
            $manifest_no = $manifest_val->manifest_no;
            $challan_date = $manifest_val->challan_date;
            $despatch_from = $manifest_val->despatch_from;
            $despatch_to = $manifest_val->despatch_to;
            $lorry_no = $manifest_val->lorry_no;
        }
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
                            <h2>EDIT BRANCH UNLOAD SHIPMENT FOR MANIFEST NO. : <b><?php echo $manifest_no; ?></b></h2>
                        </div>
                        <!-- Input -->
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="body">
                                        <b class="text-success" id="success_message" style="font-size: 18px;"></b>
                                        <b class="text-danger" id="error_message" style="font-size: 18px;"></b>
                                        <div class="row clearfix">
                                            <div class="col-sm-6">
                                                <!--<div class="form-group">
                                                <label>SOURCE MANIFEST NO</label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="text" tabindex="1" class="form-control" name="source_manifest_no" id="source_manifest_no" placeholder="ENTER MANIFEST NO" value="<?php echo $source_manifest_no; ?>"/>
                                                </div>
                                                <b class="text-danger" id="source_manifest_noErr"></b>
                                            </div>-->
                                                
                                                <div class="form-group">
                                                    <label>DESPATCH FROM</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="3" class="form-control" name="despatch_from" id="despatch_from" placeholder="ENTER DESPATCH FROM" value="<?php echo $despatch_from; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="despatch_fromErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>LORRY NO</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="5" class="form-control" name="lorry_no" id="lorry_no" placeholder="ENTER LORRY NO" value="<?php echo $lorry_no; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="lorry_noErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" tabindex="6" name="edit_branch_unload_shipment" id="edit_branch_unload_shipment" class="btn btn-primary" onclick="edit_branch_unload_shipment();">
                                                        SAVE
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>CHALLAN DATE</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="date" tabindex="2" class="form-control" name="challan_date" id="challan_date" placeholder="ENTER CHALLAN DATE" value="<?php echo $challan_date; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="challan_dateErr"></b>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>DESPATCH TO</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="4" class="form-control" name="despatch_to" id="despatch_to" placeholder="ENTER DESPATCH TO" value="<?php echo $despatch_to; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="despatch_toErr"></b>
                                                </div>

                                            </div>
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
                    function edit_branch_unload_shipment() {
                        var login_user = "<?php echo $login_user; ?>";
                        var branch_ship_id = "<?php echo $branch_ship_id; ?>";
                        //var source_manifest_no = $("#source_manifest_no").val().trim();
                        var despatch_from = $("#despatch_from").val().trim();
                        var lorry_no = $("#lorry_no").val().trim();
                        var challan_date = $("#challan_date").val().trim();
                        var despatch_to = $("#despatch_to").val().trim();

                        if ((despatch_from === "") || (lorry_no === "") || /*(source_manifest_no === "") ||*/ (challan_date === "") || (despatch_to === "")) {
                        $("#error_message").html("Provide all the fields<br/><br/>");
                        // $('#source_manifest_noErr').text(source_manifest_no===""?"Required":"");
                            $('#despatch_fromErr').text(despatch_from === "" ? "Required" : "");
                            $('#lorry_noErr').text(lorry_no === "" ? "Required" : "");
                            $('#challan_dateErr').text(challan_date === "" ? "Required" : "");
                            $('#despatch_toErr').text(despatch_to === "" ? "Required" : "");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "getAPI.php?edit_branch_unload_shipment",
                                dataType: "json",
                                data: {
                                    branch_ship_id: branch_ship_id,
                                    login_user: login_user,
                                   // source_manifest_no: source_manifest_no,
                                    despatch_from: despatch_from,
                                    lorry_no: lorry_no,
                                    challan_date: challan_date,
                                    despatch_to: despatch_to
                                },
                                success: function (RetVal) {
                                    if (RetVal.message === "Success") {
                                        $("#success_message").html(RetVal.data + "<br/><br/>");
                                        $("#error_message").text("");
                                        $('#despatch_fromErr').text("");
                                        $('#lorry_noErr').text("");
                                        $('#challan_dateErr').text("");
                                        $('#despatch_toErr').text("");
                                       // $('#source_manifest_noErr').text("");
                                    } else {
                                        $("#error_message").html(RetVal.message + "<br/><br/>");
                                        $("#success_message").text("");
                                       //  var source_manifest_noErr = JSON.parse(RetVal.data).Source_manifestErr;
                                         var despatch_fromErr = JSON.parse(RetVal.data).Despatch_fromErr;
                                        var lorry_noErr = JSON.parse(RetVal.data).Lorry_noErr;
                                        var challan_dateErr = JSON.parse(RetVal.data).Challan_dateErr;
                                        var despatch_toErr = JSON.parse(RetVal.data).Despatch_toErr;

                                        if (despatch_fromErr === null) {
                                            despatch_fromErr = "";
                                        }
                                   /* if (source_manifest_noErr === null) {
                                        source_manifest_noErr = "";
                                    }*/
                                        if (lorry_noErr === null) {
                                            lorry_noErr = "";
                                        }
                                        if (challan_dateErr === null) {
                                            challan_dateErr = "";
                                        }
                                        if (despatch_toErr === null) {
                                            despatch_toErr = "";
                                        }
                                        $('#despatch_fromErr').text("");
                                        $('#lorry_noErr').text("");
                                        $('#challan_dateErr').text("");
                                        $('#despatch_toErr').text("");
                                      //  $('#source_manifest_noErr').text("");
                                      //  $('#source_manifest_noErr').text(source_manifest_noErr);
                                        $('#despatch_fromErr').text(despatch_fromErr);
                                        $('#lorry_noErr').text(lorry_noErr);
                                        $('#challan_dateErr').text(challan_dateErr);
                                        $('#despatch_toErr').text(despatch_toErr);
                                    }

                                }
                            });
                        }
                    }
                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("location:index.php");
}
?>