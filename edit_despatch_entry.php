<?php
$main_page = "Local shipment";
$page = "Edit despatch entry";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
    if ($_GET['despatch_id']) {
        $despatch_id = $_GET['despatch_id'];
        $despatchSQL = "SELECT * FROM despatch WHERE id='$despatch_id'";
        $despatch_fetch = json_decode(ret_json_str($despatchSQL));
        foreach ($despatch_fetch as $despatch_val) {
            $unload_id = $despatch_val->unload_id;
            $booking_code = $despatch_val->booking_code;
            $booking_date = $despatch_val->booking_date;
            $bilty_no = $despatch_val->bilty_no;
            $hbilty_no = $despatch_val->bilty_no;
            $contents = $despatch_val->content_id;
            $private_mark_id = $despatch_val->private_mark_id;
            $packet_quantity = $despatch_val->packet_quantity;
            $packet_received = $despatch_val->packet_received;
            $weight = $despatch_val->weight;
            $payment_status = $despatch_val->payment_status;
            $pay_cod_amt = $despatch_val->pay_cod_amt;
            $destination = $despatch_val->destination;
            $consigner_name = $despatch_val->consigner_name;
            $consigner_gst = $despatch_val->consigner_gst;
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
                            <h2>EDIT DESPATCH ENTRY</h2>
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
                                                    <label>BOOKING CODE</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="1" class="form-control" name="booking_code" id="booking_code" placeholder="ENTER BOOKING CODE" value="<?php echo $booking_code; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="booking_codeErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>BILTY NO</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="3" class="form-control" name="bilty_no" id="bilty_no" placeholder="ENTER BILTY NO" value="<?php echo $bilty_no; ?>"/>
                                                        <input type="hidden" tabindex="3" class="form-control" name="hbilty_no" id="hbilty_no" placeholder="ENTER BILTY NO" value="<?php echo $hbilty_no; ?>"/>
                                                    </div>
                                                    <b class="text-danger" id="bilty_noErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>PRIVATE MARK</label><span class="text-danger"> *</span>
                                                    <a href="add_private_mark.php" target="_blank" class="btn btn-primary" style="float: right;">
                                                        Add more</a>
                                                    <div class="form-line">
                                                        <select name="private_mark" tabindex="5" class="form-control" id="private_mark" data-live-search="true">
                                                            <option value="" <?php
                                                            if ($private_mark_id == "") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?> style="margin-left: 35px;" >SELECT</option>
                                                                    <?php
                                                                    $pmSQL = "SELECT * FROM mas_private_mark WHERE status=1";
                                                                    $pm_fetch = json_decode(ret_json_str($pmSQL));
                                                                    foreach ($pm_fetch as $pm_val) {
                                                                        ?>
                                                                <option value="<?php echo $pm_val->id; ?>"
                                                                <?php
                                                                if ($private_mark_id == $pm_val->id) {
                                                                    echo "selected='selected'";
                                                                }
                                                                ?>
                                                                        style="margin-left: 35px;" ><?php echo $pm_val->private_mark; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </select>
                                                    </div>
                                                    <b class="text-danger" id="private_markErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>TOTAL NO. OF PACKETS</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="7" class="form-control" name="no_packets" id="no_packets" placeholder="ENTER TOTAL NO. OF PACKETS" value="<?php echo $packet_quantity; ?>"/>
                                                    </div>
                                                    <b class="text-danger" id="no_packetsErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>PAYMENT STATUS</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <select name="paid_topay" tabindex="9" id="paid_topay" class="form-control">
                                                            <option value="P" <?php
                                                            if ($payment_status == "P") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>PAID</option>
                                                            <option value="C" <?php
                                                            if ($payment_status == "C") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>COD / TO PAY</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>CONSIGNER NAME</label><span class="text-danger"> </span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="11" class="form-control" name="consigner_name" id="consigner_name" placeholder="ENTER CONSIGNER NAME" value="<?php echo $consigner_name; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>WEIGHT (in KG)</label><span class="text-danger"> </span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="8" step="0.01" class="form-control" name="weight" id="weight" placeholder="ENTER WEIGHT" value="<?php echo $weight; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="weightErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" tabindex="11" name="edit_dispatch_entry" id="edit_dispatch_entry" class="btn btn-primary" onclick="edit_dispatch_entry();">
                                                        SAVE
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>BOOKING DATE</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="date" tabindex="2" class="form-control" name="booking_date" id="booking_date" placeholder="ENTER BOOKING DATE" value="<?php echo $booking_date; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="booking_dateErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>CONTENTS</label><span class="text-danger"> *</span>
                                                    <a href="add_goods.php" target="_blank" class="btn btn-primary" style="float: right;">
                                                        Add more</a>
                                                    <div class="form-line">
                                                        <select name="contents" tabindex="4" class="form-control" id="contents" data-live-search="true">
                                                            <option value="" style="margin-left: 35px;">SELECT</option>
                                                            <?php
                                                            $cnSQL = "SELECT * FROM mas_contents WHERE status=1";
                                                            $cn_fetch = json_decode(ret_json_str($cnSQL));
                                                            foreach ($cn_fetch as $cn_val) {
                                                                ?>
                                                                <option value="<?php echo $cn_val->id; ?>" <?php
                                                                if ($contents == $cn_val->id) {
                                                                    echo "selected='selected'";
                                                                }
                                                                ?>
                                                                        style="margin-left: 35px;" ><?php echo $cn_val->contents_desc; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </select></div>
                                                    <b class="text-danger" id="contentsErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>DESTINATION NAME / CODE</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="6" class="form-control" name="dest_name_code" id="dest_name_code" placeholder="ENTER DESTINATION NAME / CODE" value="<?php echo $destination; ?>"/>
                                                    </div>
                                                    <b class="text-danger" id="dest_name_codeErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>NO. OF PACKETS RECEIVED</label><span class="text-danger"></span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="7" class="form-control" name="no_packets_received" id="no_packets_received" placeholder="ENTER NO. OF PACKETS RECEIVED" value="<?php echo $packet_received; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>PAID / TO PAY AMOUNT</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="10" step="0.01" class="form-control" name="paid_cod_amt" id="paid_cod_amt" placeholder="ENTER PAID / TO PAY AMOUNT AMOUNT" value="<?php echo $pay_cod_amt; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="paid_cod_amtErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>CONSIGNER GST</label><span class="text-danger"></span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="12" class="form-control" name="consigner_gst" id="consigner_gst" placeholder="ENTER CONSIGNER GST" value="<?php echo $consigner_gst; ?>"/>
                                                    </div>
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
                            $("#no_packets_received").val($(this).val());
                        });
                    });
                    function edit_dispatch_entry() {
                        var despatch_id = "<?php echo $despatch_id; ?>";
                        var login_user = "<?php echo $login_user; ?>";
                        var unload_id = "<?php echo $unload_id; ?>";
                        var booking_code = $("#booking_code").val().trim();
                        var bilty_no = $("#bilty_no").val().trim();
                        var hbilty_no = $("#hbilty_no").val().trim();
                        var private_mark = $("#private_mark").val().trim();
                        var no_packets = $("#no_packets").val().trim();
                        var no_packets_received = $("#no_packets_received").val().trim();
                        var paid_topay = $("#paid_topay").val().trim();
                        var booking_date = $("#booking_date").val().trim();
                        var contents = $("#contents").val().trim();
                        var dest_name_code = $("#dest_name_code").val().trim();
                        var paid_cod_amt = $("#paid_cod_amt").val().trim();
                        var weight = $("#weight").val().trim();
                        var consigner_gst = $("#consigner_gst").val().trim();
                        var consigner_name = $("#consigner_name").val().trim();

                        if ((booking_code === "") || (private_mark === "") || (bilty_no === "") || (no_packets === "") || (paid_topay === "") || (booking_date === "") || (contents === "") || (dest_name_code === "") || (paid_cod_amt === "")) {
                            $("#error_message").html("");
                            $("#error_message").html("Provide all the fields<br/><br/>");
                        } else {
                            if (weight === "") {
                                weight = "0.00";
                            }
                            if (no_packets_received === "") {
                                no_packets_received = "0.00";
                            }
                            $.ajax({
                                type: "POST",
                                url: "getAPI.php?edit_despatch",
                                dataType: "json",
                                data: {
                                    despatch_id: despatch_id,
                                    login_user: login_user,
                                    unload_id: unload_id,
                                    booking_code: booking_code,
                                    bilty_no: bilty_no,
                                    hbilty_no: hbilty_no,
                                    private_mark: private_mark,
                                    no_packets: no_packets,
                                    no_packets_recvd: no_packets_received,
                                    paid_topay: paid_topay,
                                    booking_date: booking_date,
                                    contents: contents,
                                    dest_name_code: dest_name_code,
                                    paid_cod_amt: paid_cod_amt,
                                    weight: weight,
                                    consigner_name: consigner_name,
                                    consigner_gst: consigner_gst
                                },
                                success: function (RetVal) {
                                    if (RetVal.message === "Success") {
                                        $("#success_message").html(RetVal.data + "<br/><br/>");
                                        $("#error_message").text("");
                                        $('#booking_codeErr').text("");
                                        $('#bilty_noErr').text("");
                                        $('#no_packetsErr').text("");
                                        $('#booking_dateErr').text("");
                                        $('#contentsErr').text("");
                                        $('#dest_name_codeErr').text("");
                                        $('#paid_cod_amtErr').text("");
                                        $('#private_mark').text("");
                                        $('#hbilty_no').val(bilty_no);
                                    } else {
                                        $("#error_message").html(RetVal.message + "<br/><br/>");
                                        $("#success_message").text("");
                                        var booking_codeErr = JSON.parse(RetVal.data).Booking_codeErr;
                                        var bilty_noErr = JSON.parse(RetVal.data).Bilty_noErr;
                                        var no_packetsErr = JSON.parse(RetVal.data).Packet_noErr;
                                        var booking_dateErr = JSON.parse(RetVal.data).Booking_dateErr;
                                        var contentsErr = JSON.parse(RetVal.data).ContentsErr;
                                        var dest_name_codeErr = JSON.parse(RetVal.data).Destination_nameErr;
                                        var paid_cod_amtErr = JSON.parse(RetVal.data).Paid_cod_amtErr;
                                        var private_markErr = JSON.parse(RetVal.data).Private_markErr;

                                        if (booking_codeErr === null) {
                                            booking_codeErr = "";
                                        }
                                        if (bilty_noErr === null) {
                                            bilty_noErr = "";
                                        }
                                        if (no_packetsErr === null) {
                                            no_packetsErr = "";
                                        }
                                        if (private_markErr === null) {
                                            private_markErr = "";
                                        }
                                        if (booking_dateErr === null) {
                                            booking_dateErr = "";
                                        }
                                        if (contentsErr === null) {
                                            contentsErr = "";
                                        }
                                        if (dest_name_codeErr === null) {
                                            dest_name_codeErr = "";
                                        }
                                        if (paid_cod_amtErr === null) {
                                            paid_cod_amtErr = "";
                                        }
                                        $('#booking_codeErr').text("");
                                        $('#bilty_noErr').text("");
                                        $('#no_packetsErr').text("");
                                        $('#booking_dateErr').text("");
                                        $('#private_markErr').text("");
                                        $('#contentsErr').text("");
                                        $('#dest_name_codeErr').text("");
                                        $('#paid_cod_amtErr').text("");
                                        $('#booking_codeErr').text(booking_codeErr);
                                        $('#bilty_noErr').text(bilty_noErr);
                                        $('#private_markErr').text(private_markErr);
                                        $('#no_packetsErr').text(no_packetsErr);
                                        $('#booking_dateErr').text(booking_dateErr);
                                        $('#contentsErr').text(contentsErr);
                                        $('#dest_name_codeErr').text(dest_name_codeErr);
                                        $('#paid_cod_amtErr').text(paid_cod_amtErr);
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