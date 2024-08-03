<?php
$main_page = "Branch shipment";
$page = "Branch despatch entry";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
    if ($_GET['branch_ship_id']) {
        $branch_ship_id = $_GET['branch_ship_id'];
        $manifestSQL = "SELECT * FROM branch_unload_shipment WHERE id='$branch_ship_id'";
        $manifest_fetch = json_decode(ret_json_str($manifestSQL));
        foreach ($manifest_fetch as $manifest_val) {
            $manifest_no = $manifest_val->manifest_no;
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
                            <h2>BRANCH DESPATCH ENTRY FOR <b>MANIFEST NO. : <?php echo $manifest_no; ?></b></h2>
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
                                                <div class="form-group">
                                                    <label>BILTY NO</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="1" class="form-control" name="bilty_no" id="bilty_no" placeholder="ENTER BILTY NO" />
                                                    </div>
                                                    <b class="text-danger" id="bilty_noErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>TOTAL NO. OF PACKETS</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="3" class="form-control" name="no_packets" id="no_packets" placeholder="ENTER TOTAL NO. OF PACKETS" />
                                                    </div>
                                                    <b class="text-danger" id="no_packetsErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>WEIGHT (in KG)</label><span class="text-danger"> </span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="4" step="0.01" class="form-control" name="weight" id="weight" placeholder="ENTER WEIGHT" />
                                                    </div>
                                                    <b class="text-danger" id="weightErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" tabindex="7" name="add_branch_dispatch_entry" id="add_branch_dispatch_entry" class="btn btn-primary" onclick="add_branch_dispatch_entry();">
                                                        SAVE
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>BOOKING CODE</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="5" class="form-control" name="booking_code" id="booking_code" placeholder="ENTER BOOKING CODE" />
                                                    </div>
                                                    <b class="text-danger" id="booking_codeErr"></b>
                                                </div>
                                                   <div class="form-group">
                                                    <label>NO. OF PACKETS RECEIVED</label><span class="text-danger"> </span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="3" class="form-control" name="no_packets_recvd" id="no_packets_recvd" placeholder="ENTER NO. OF PACKETS RECEIVED" value=""/>
                                                    </div>
                                                 </div>
                                                <div class="form-group">
                                                    <label>CONTENTS</label><span class="text-danger"> *</span>
                                                    <a href="add_goods.php" target="_blank" class="btn btn-primary" style="float: right;">
                                                        Add more</a>
                                                    <div class="form-line">
                                                        <select name="contents" tabindex="2" class="form-control" id="contents" data-live-search="true">
                                                            <option value="" style="margin-left: 35px;">SELECT</option>
                                                            <?php
                                                            $cnSQL = "SELECT * FROM mas_contents WHERE status=1";
                                                            $cn_fetch = json_decode(ret_json_str($cnSQL));
                                                            foreach ($cn_fetch as $cn_val) {
                                                                ?>
                                                                <option value="<?php echo $cn_val->id; ?>"
                                                                        style="margin-left: 35px;" ><?php echo $cn_val->contents_desc; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </select>
                                                    </div>
                                                    <b class="text-danger" id="contentsErr"></b>
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
                     $(document).ready(function () {
                        $("#no_packets").keyup(function () {
                            $("#no_packets_recvd").val($(this).val());
                        });
                    });
                    function add_branch_dispatch_entry() {
                        var login_user = "<?php echo $login_user; ?>";
                        var branch_ship_id = "<?php echo $branch_ship_id; ?>";
                        var bilty_no = $("#bilty_no").val().trim();
                        var no_packets = $("#no_packets").val().trim();
                        var no_packets_recvd = $("#no_packets_recvd").val().trim();
                        var contents = $("#contents").val().trim();
                        var weight = $("#weight").val().trim();
                        var booking_code = $("#booking_code").val().trim();

                        if ((bilty_no === "") || (booking_code === "") || (no_packets === "") || (contents === "")) {
                            $("#error_message").html("");
                            $('#bilty_noErr').text(bilty_no === "" ? "Required" : "");
                            $('#no_packetsErr').text(no_packets === "" ? "Required" : "");
                            $('#contentsErr').text(contents === "" ? "Required" : "");
                            $('#booking_codeErr').text(booking_code === "" ? "Required" : "");
                            $("#error_message").html("Provide all the fields<br/><br/>");

                        } else {
                            if (weight === "") {
                                weight = "0.00";
                            }
                             if (no_packets_recvd === "") {
                                no_packets_recvd = "0";
                            }
                            $.ajax({
                                type: "POST",
                                url: "getAPI.php?add_branch_despatch",
                                dataType: "json",
                                data: {
                                    branch_ship_id: branch_ship_id,
                                    login_user: login_user,
                                    bilty_no: bilty_no,
                                    no_packets: no_packets,
                                    no_packets_recvd: no_packets_recvd,
                                    contents: contents,
                                    booking_code: booking_code,
                                    weight: weight
                                },
                                success: function (RetVal) {
                                    if (RetVal.message === "Success") {
                                        $("#success_message").html(RetVal.data + "<br/><br/>");
                                        $("#error_message").text("");

                                        $("#bilty_no").val("");
                                        $("#no_packets").val("");
                                        $("#no_packets_recvd").val("");
                                        $("#contents").val("");
                                        $("#booking_code").val("");
                                        $("#weight").val("");
                                        $('#bilty_noErr').text("");
                                        $('#no_packetsErr').text("");
                                        $('#contentsErr').text("");
                                        $('#weightErr').text("");
                                        $('#booking_codeErr').text("");
                                    } else {
                                        $("#error_message").html(RetVal.message + "<br/><br/>");
                                        $("#success_message").text("");
                                        var bilty_noErr = JSON.parse(RetVal.data).Bilty_noErr;
                                        var no_packetsErr = JSON.parse(RetVal.data).Packet_noErr;
                                        var contentsErr = JSON.parse(RetVal.data).ContentsErr;
                                        var weightErr = JSON.parse(RetVal.data).WeightErr;
                                        var booking_codeErr = JSON.parse(RetVal.data).Booking_codeErr;
                                        if (bilty_noErr === null) {
                                            bilty_noErr = "";
                                        }
                                        if (no_packetsErr === null) {
                                            no_packetsErr = "";
                                        }
                                        if (contentsErr === null) {
                                            contentsErr = "";
                                        }
                                        if (weightErr === null) {
                                            weightErr = "";
                                        }
                                        if (booking_codeErr === null) {
                                            booking_codeErr = "";
                                        }
                                        $('#bilty_noErr').text("");
                                        $('#no_packetsErr').text("");
                                        $('#contentsErr').text("");
                                        $('#weightErr').text("");
                                        $('#booking_codeErr').text("");
                                        $('#bilty_noErr').text(bilty_noErr);
                                        $('#no_packetsErr').text(no_packetsErr);
                                        $('#weightErr').text(weightErr);
                                        $('#contentsErr').text(contentsErr);
                                        $('#booking_codeErr').text(booking_codeErr);
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