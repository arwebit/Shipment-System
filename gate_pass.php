<?php
$main_page = "Local shipment";
$page = "Generate gate pass";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
    if ($_GET['despatch_id']) {
        $despatch_id = $_GET['despatch_id'];
        $despatchSQL = "SELECT * FROM despatch a LEFT JOIN gatepass b ON a.id=b.despatch_id WHERE a.id='$despatch_id'";
        $despatch_fetch = json_decode(ret_json_str($despatchSQL));
        foreach ($despatch_fetch as $despatch_val) {
            $gatepass_id = $despatch_val->gatepass_id;
            $amt = $despatch_val->pay_cod_amt;
            $bilty_no = $despatch_val->bilty_no;
            $way_bill_no = $despatch_val->way_bill_no;
            $payment_type = $despatch_val->payment_type;
            $gatepass_date = $despatch_val->gatepass_date;
            $cheque_no = $despatch_val->cheque_no;
            $received_amount = $despatch_val->received_amount;
            $cgst = $despatch_val->cgst;
            $sgst = $despatch_val->sgst;
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
                            <h2>GENERATE GATE PASS FOR 
                                <b>BILTY NO : <?php echo $bilty_no; ?>, AMOUNT TO BE PAID : Rs. <?php echo $amt; ?></b></h2>
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
                                                    <label>WAY BILL NO</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="1" class="form-control" name="way_bill_no" id="way_bill_no" placeholder="ENTER WAY BILL NO" value="<?php echo $way_bill_no; ?>"/>
                                                    </div>
                                                    <b class="text-danger" id="way_bill_noErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>CGST (in %)</label><span class="text-danger"> </span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="3" step="0.01" class="form-control" name="cgst" id="cgst" placeholder="ENTER CGST (in %)" value="<?php echo $cgst; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>RECEIVED AMOUNT (in Rs.)</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="5" step="0.01" class="form-control" name="received_amount" id="received_amount" placeholder="ENTER RECEIVED AMOUNT (in Rs.)" value="<?php echo $received_amount; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="received_amountErr"></b>
                                                </div>

                                                <div class="form-group">
                                                    <label>CHEQUE NO</label><span class="text-danger"> </span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="7" class="form-control" name="cheque_no" id="cheque_no" placeholder="ENTER CHEQUE NO" value="<?php echo $cheque_no; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" tabindex="8" name="generate_gate_pass" id="generate_gate_pass" class="btn btn-primary" onclick="generate_gate_pass();">
                                                        SAVE
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>GATEPASS DATE</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="date" tabindex="2" class="form-control" name="gatepass_date" id="gatepass_date" placeholder="ENTER GATEPASS DATE" value="<?php echo $gatepass_date; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="gatepass_dateErr"></b>
                                                </div>

                                                <div class="form-group">
                                                    <label>SGST (in %)</label><span class="text-danger"> </span>
                                                    <div class="form-line">
                                                        <input type="number" tabindex="4" step="0.01" class="form-control" name="sgst" id="sgst" placeholder="ENTER SGST (in %)" value="<?php echo $sgst; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>PAYMENT TYPE</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <select name="payment_type" tabindex="6" id="payment_type" class="form-control">
                                                            <option value="CA" <?php
                                                            if ($payment_type == "CA") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>CASH</option>
                                                            <option value="CH" <?php
                                                            if ($payment_type == "CH") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>CHEQUE</option>
                                                        </select>
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
                    function generate_gate_pass() {
                        var despatch_id = "<?php echo $despatch_id; ?>";
                        var login_user = "<?php echo $login_user; ?>";
                        var gatepass_id = "<?php echo $gatepass_id; ?>";
                        var way_bill_no = $("#way_bill_no").val().trim();
                        var cgst = $("#cgst").val().trim();
                        var payment_type = $("#payment_type").val().trim();
                        var gatepass_date = $("#gatepass_date").val().trim();
                        var received_amount = $("#received_amount").val().trim();
                        var sgst = $("#sgst").val().trim();
                        var cheque_no = $("#cheque_no").val().trim();

                        if ((way_bill_no === "") || (payment_type === "") || (gatepass_date === "")) {
                            $("#error_message").html("");
                            $("#error_message").html("Provide all the fields<br/><br/>");
                            $('#gatepass_dateErr').text(gatepass_date === "" ? "Required" : "");
                            $('#way_bill_noErr').text(way_bill_no === "" ? "Required" : "");
                            $('#received_amountErr').text(received_amount === "" ? "Required" : "");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "getAPI.php?gen_gatepass",
                                dataType: "json",
                                data: {
                                    gatepass_id: gatepass_id,
                                    despatch_id: despatch_id,
                                    login_user: login_user,
                                    way_bill_no: way_bill_no,
                                    cgst: cgst,
                                    payment_type: payment_type,
                                    gatepass_date: gatepass_date,
                                    received_amount: received_amount,
                                    sgst: sgst,
                                    cheque_no: cheque_no
                                },
                                success: function (RetVal) {
                                    if (RetVal.message === "Success") {
                                        $("#success_message").html(RetVal.data + "<br/><br/>");
                                        $("#error_message").text("");
                                        $('#gatepass_dateErr').text("");
                                        $('#way_bill_noErr').text("");
                                        $('#received_amountErr').text("");
                                    } else {
                                        $("#error_message").html(RetVal.message + "<br/><br/>");
                                        $("#success_message").text("");
                                        var gatepass_dateErr = JSON.parse(RetVal.data).Gatepass_dateErr;
                                        var way_bill_noErr = JSON.parse(RetVal.data).Way_bill_noErr;
                                        var received_amountErr = JSON.parse(RetVal.data).ReceivedAmtErr;

                                        if (gatepass_dateErr === null) {
                                            gatepass_dateErr = "";
                                        }
                                        if (way_bill_noErr === null) {
                                            way_bill_noErr = "";
                                        }
                                        if (received_amountErr === null) {
                                            received_amountErr = "";
                                        }

                                        $('#gatepass_dateErr').text("");
                                        $('#way_bill_noErr').text("");
                                        $('#received_amountErr').text("");
                                        $('#gatepass_dateErr').text(gatepass_dateErr);
                                        $('#way_bill_noErr').text(way_bill_noErr);
                                        $('#received_amountErr').text("");
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