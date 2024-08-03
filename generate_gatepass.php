<?php
$main_page = "Local shipment";
$page = "Generate gate pass";
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
                        <h2>GENERATE GATE PASS</h2>
                    </div>
                    <!-- Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>SEARCH BY GATE PASS / BILTY NO </label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="gatepass_bilty_no" id="gatepass_bilty_no" placeholder="ENTER GATE PASS / BILTY NO" onkeyup="search_gatepass(this.value);" />
                                                </div>
                                                <b class="text-danger" id="gatepass_bilty_noErr"></b>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="print_receipt('printableArea');">
                                        PRINT GATE PASS
                                    </button><br/><br/>
                                    <div id="printableArea">
                                        <div style="border:1px solid #000000; padding: 20px; margin-bottom:5px;">
                                            <center>
                                                Customer Copy
                                            </center>
                                            <?php
                                            echo get_address();
                                            ?>

                                            <div style="width: 100%; margin-top: 10px;">
                                                <div style="width: 33%; float: left;">
                                                    No. <span id="gatepass_no"></span>
                                                </div>
                                                <div style="width: 33%; float: left; margin-left: 50px;">
                                                    G.S.T. No.: <?php echo getGST(); ?>
                                                </div>
                                                <div style="width: 33%; float: right; margin-right: -100px;">
                                                    Date : <span id="gatepass_date"></span>
                                                </div>
                                            </div><br/><br/>
                                            <hr/><br/>
                                            Received with thanks from M/S. <span id="party_name"></span><br/>
                                            GSTIN / Aadhar <span id="gstin"></span>, Booking code <span id="booking_code"></span>
                                            against C/N no. <span id="bilty_no"></span>,                                            <br/>
                                            No. of packing <span id="no_pckg"></span>, Weight <span id="weight"></span>, 
                                            Contents : <span id="content"></span><br/>
                                            Way Bill No. <span id="wbn"></span> of amount of
                                            Rs. <span id="amount"></span> in words <span id="amount_words"></span>
                                            as per detail below<br/><br/>
                                            <hr/><br/>
                                            <table class="table">
                                                <tr>
                                                    <td width="50%">
                                                        <div style="float: left;">
                                                            <table style="width:300px; text-align: left;">
                                                                <!--This is a comment. Comments are not displayed in the browser
    <tr>
                                                                    <th>To pay Amount</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="cod_amt_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="cod_amt_dc"></span></td>
                                                                </tr>-->
                                                                <tr>
                                                                    <th>Received Amount</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="recv_amt_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="recv_amt_dc"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>CGST (<span id="cgst_p"></span> %)</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="cgst_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="cgst_dc"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>SGST (<span id="sgst_p"></span> %)</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="sgst_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="sgst_dc"></span>
                                                                    </td>
                                                                </tr>
                                                                <!--<tr>
                                                                    <th>Discount Rs</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="discount_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="discount_dc"></span>
                                                                    </td>
                                                                </tr></tr>-->

                                                                <tr>
                                                                    <th> TOTAL Rs. </th>
                                                                    <td style="text-align: right;">
                                                                        <span id="tot_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="tot_dc"></span></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </td>
                                                    <td valign="top">
                                                        <div style="float: left; margin-left: 50px;">
                                                            <div style="border: 1px solid black; padding: 10px;">
                                                                GST will be paid by consignor/Consignee
                                                            </div><br/><br/>
                                                            FOR - AMAR JYOTI ROADLINK
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                        <br/>
                                        <div id="gp_receipt" style="border:1px solid #000000; padding: 20px; margin-bottom:5px; display: none;">
                                            <center>
                                                Office Copy
                                            </center>
                                            <?php
                                            echo get_address();
                                            ?>

                                            <div style="width: 100%; margin-top: 10px;">
                                                <div style="width: 33%; float: left;">
                                                    No. <span id="off_gatepass_no"></span>
                                                </div>
                                                <div style="width: 33%; float: left; margin-left: 50px;">
                                                    G.S.T. No.: <?php echo getGST(); ?>
                                                </div>
                                                <div style="width: 33%; float: right; margin-right: -100px;">
                                                    Date : <span id="off_gatepass_date"></span>
                                                </div>
                                            </div><br/><br/>
                                            <hr/><br/>
                                            Received with thanks from M/S. <span id="off_party_name"></span><br/>
                                            GSTIN / Aadhar <span id="off_gstin"></span> Booking code <span id="off_booking_code"></span>
                                            against C/N no. <span id="off_bilty_no"></span><br/>
                                            No. of packing <span id="off_no_pckg"></span>, Weight <span id="off_weight"></span>, 
                                            Contents : <span id="off_content"></span><br/>
                                            Way Bill No. <span id="off_wbn"></span> of amount of
                                            Rs. <span id="off_amount"></span> in words <span id="amount_words"></span>
                                            as per detail below<br/><br/>
                                            <hr/><br/>
                                            <table class="table">
                                                <tr>
                                                    <td width="50%">
                                                        <div style="float: left;">
                                                            <table style="width:300px; text-align: left;">
                                                                <!--This is a comment. Comments are not displayed in the browser
                                                               <tr>
                                                                                                                                   <th>To pay Amount</th>
                                                                                                                                   <td style="text-align: right;">
                                                                                                                                       <span id="cod_amt_wh"></span>
                                                                                                                                   </td>
                                                                                                                                   <td style="text-align: right;">
                                                                                                                                       <span id="cod_amt_dc"></span></td>
                                                                                                                               </tr>-->
                                                                <tr>
                                                                    <th>Received Amount</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="off_recv_amt_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="off_recv_amt_dc"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>CGST (<span id="cgst_p"></span> %)</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="off_cgst_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="off_cgst_dc"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>SGST (<span id="sgst_p"></span> %)</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="off_sgst_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="off_sgst_dc"></span>
                                                                    </td>
                                                                </tr>
                                                                <!--<tr>
                                                                    <th>Discount Rs</th>
                                                                    <td style="text-align: right;">
                                                                        <span id="discount_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="discount_dc"></span>
                                                                    </td>
                                                                </tr></tr>-->
                                                                <tr>
                                                                    <th> TOTAL Rs. </th>
                                                                    <td style="text-align: right;">
                                                                        <span id="off_tot_wh"></span>
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <span id="off_tot_dc"></span></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </td>
                                                    <td valign="top">
                                                        <div style="float: left; margin-left: 50px;">
                                                            <div style="border: 1px solid black; padding: 10px;">
                                                                GST will be paid by consignor/Consignee
                                                            </div><br/><br/>
                                                            FOR - AMAR JYOTI ROADLINK
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

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
                function print_receipt(divName) {
                    document.getElementById("gp_receipt").style.display = "block";
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    window.location.href = "generate_gatepass.php";
                }
            </script>
            <script>
                function search_gatepass(gatepass_bilty_no) {
                    if (gatepass_bilty_no === "") {
                        $("#booking_code").text("");
                        $("#gatepass_no").text("");
                        $("#gatepass_date").text("");
                        $("#party_name").text("");
                        $("#gstin").text("");
                        $("#weight").text("");
                        $("#content").text("");
                        $("#amount").text("");
                        $("#amount_words").text("");
                        $("#cash_cheque").text("");
                        $("#cheque_no").text("");
                        $("#booking_date").text("");
                        $("#private_mark").text("");
                        $("#wbn").text("");
                        $("#no_pckg").text("");
                        $("#bilty_no").text("");
                        $("#cod_amt_wh").text("");
                        $("#cod_amt_dc").text("");
                        $("#cgst_wh").text("");
                        $("#cgst_dc").text("");
                        $("#sgst_wh").text("");
                        $("#sgst_dc").text("");
                        $("#discount_wh").text("");
                        $("#discount_dc").text("");
                        $("#tot_wh").text("");
                        $("#tot_dc").text("");
                        $("#cgst_p").text("");
                        $("#sgst_p").text("");
                        $("#recv_amt_wh").text("");
                        $("#recv_amt_dc").text("");

                        $("#off_booking_code").text("");
                        $("#off_gatepass_no").text("");
                        $("#off_gatepass_date").text("");
                        $("#off_weight").text("");
                        $("#off_content").text("");
                        $("#off_party_name").text("");
                        $("#off_gstin").text("");
                        $("#off_amount").text("");
                        $("#off_amount_words").text("");
                        $("#off_cash_cheque").text("");
                        $("#off_cheque_no").text("");
                        $("#off_booking_date").text("");
                        $("#off_private_mark").text("");
                        $("#off_wbn").text("");
                        $("#off_no_pckg").text("");
                        $("#off_bilty_no").text("");
                        $("#off_cod_amt_wh").text("");
                        $("#off_cod_amt_dc").text("");
                        $("#off_cgst_wh").text("");
                        $("#off_cgst_dc").text("");
                        $("#off_sgst_wh").text("");
                        $("#off_sgst_dc").text("");
                        $("#off_discount_wh").text("");
                        $("#off_discount_dc").text("");
                        $("#off_tot_wh").text("");
                        $("#off_tot_dc").text("");
                        $("#off_cgst_p").text("");
                        $("#off_sgst_p").text("");
                        $("#off_recv_amt_wh").text("");
                        $("#off_recv_amt_dc").text("");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?search_gatepass",
                            dataType: "json",
                            data: {
                                gatepass_bilty_no: gatepass_bilty_no
                            },
                            success: function (RetVal) {
                                if (RetVal.message === "Success") {
                                    $("#gatepass_bilty_noErr").text("");
                                    $("#booking_code").text(JSON.parse(RetVal.data).Booking_code);
                                    $("#gatepass_no").text(JSON.parse(RetVal.data).Gatepassno);
                                    $("#gatepass_date").text(JSON.parse(RetVal.data).GatepassDate);
                                    $("#party_name").text(JSON.parse(RetVal.data).Party_name);
                                    $("#gstin").text(JSON.parse(RetVal.data).GSTIN);
                                    $("#weight").text(JSON.parse(RetVal.data).Weight + " kg");
                                    $("#content").text(JSON.parse(RetVal.data).Content);
                                    $("#amount").text(JSON.parse(RetVal.data).Amount);
                                    $("#amount_words").text(JSON.parse(RetVal.data).Amount_words);
                                    $("#cash_cheque").text(JSON.parse(RetVal.data).Cash_cheque);
                                    $("#cheque_no").text(JSON.parse(RetVal.data).Cheque_no);
                                    $("#booking_date").text(JSON.parse(RetVal.data).BookingDate);
                                    $("#private_mark").text(JSON.parse(RetVal.data).PrivateMark);
                                    $("#wbn").text(JSON.parse(RetVal.data).WayBillNo);
                                    $("#no_pckg").text(JSON.parse(RetVal.data).PacketNo);
                                    $("#bilty_no").text(JSON.parse(RetVal.data).Biltyno);
                                    $("#cod_amt_wh").text(JSON.parse(RetVal.data).CODAmountWH);
                                    $("#cod_amt_dc").text(JSON.parse(RetVal.data).CODAmountDC);
                                    $("#cgst_wh").text(JSON.parse(RetVal.data).CGSTWH);
                                    $("#cgst_dc").text(JSON.parse(RetVal.data).CGSTDC);
                                    $("#sgst_wh").text(JSON.parse(RetVal.data).SGSTWH);
                                    $("#sgst_dc").text(JSON.parse(RetVal.data).SGSTDC);
                                    $("#discount_wh").text(JSON.parse(RetVal.data).DiscountWH);
                                    $("#discount_dc").text(JSON.parse(RetVal.data).DiscountDC);
                                    $("#tot_wh").text(JSON.parse(RetVal.data).TotWH);
                                    $("#tot_dc").text(JSON.parse(RetVal.data).TotDC);
                                    $("#cgst_p").text(JSON.parse(RetVal.data).CGST_P);
                                    $("#sgst_p").text(JSON.parse(RetVal.data).SGST_P);
                                    $("#recv_amt_wh").text(JSON.parse(RetVal.data).RecvAmtWH);
                                    $("#recv_amt_dc").text(JSON.parse(RetVal.data).RecvAmtDC);

                                    $("#off_booking_code").text(JSON.parse(RetVal.data).Booking_code);
                                    $("#off_gatepass_no").text(JSON.parse(RetVal.data).Gatepassno);
                                    $("#off_gatepass_date").text(JSON.parse(RetVal.data).GatepassDate);
                                    $("#off_weight").text(JSON.parse(RetVal.data).Weight + " kg");
                                    $("#off_content").text(JSON.parse(RetVal.data).Content);
                                    $("#off_party_name").text(JSON.parse(RetVal.data).Party_name);
                                    $("#off_gstin").text(JSON.parse(RetVal.data).GSTIN);
                                    $("#off_amount").text(JSON.parse(RetVal.data).Amount);
                                    $("#off_amount_words").text(JSON.parse(RetVal.data).Amount_words);
                                    $("#off_cash_cheque").text(JSON.parse(RetVal.data).Cash_cheque);
                                    $("#off_cheque_no").text(JSON.parse(RetVal.data).Cheque_no);
                                    $("#off_booking_date").text(JSON.parse(RetVal.data).BookingDate);
                                    $("#off_private_mark").text(JSON.parse(RetVal.data).PrivateMark);
                                    $("#off_wbn").text(JSON.parse(RetVal.data).WayBillNo);
                                    $("#off_no_pckg").text(JSON.parse(RetVal.data).PacketNo);
                                    $("#off_bilty_no").text(JSON.parse(RetVal.data).Biltyno);
                                    $("#off_cod_amt_wh").text(JSON.parse(RetVal.data).CODAmountWH);
                                    $("#off_cod_amt_dc").text(JSON.parse(RetVal.data).CODAmountDC);
                                    $("#off_cgst_wh").text(JSON.parse(RetVal.data).CGSTWH);
                                    $("#off_cgst_dc").text(JSON.parse(RetVal.data).CGSTDC);
                                    $("#off_sgst_wh").text(JSON.parse(RetVal.data).SGSTWH);
                                    $("#off_sgst_dc").text(JSON.parse(RetVal.data).SGSTDC);
                                    $("#off_discount_wh").text(JSON.parse(RetVal.data).DiscountWH);
                                    $("#off_discount_dc").text(JSON.parse(RetVal.data).DiscountDC);
                                    $("#off_tot_wh").text(JSON.parse(RetVal.data).TotWH);
                                    $("#off_tot_dc").text(JSON.parse(RetVal.data).TotDC);
                                    $("#off_cgst_p").text(JSON.parse(RetVal.data).CGST_P);
                                    $("#off_sgst_p").text(JSON.parse(RetVal.data).SGST_P);
                                    $("#off_recv_amt_wh").text(JSON.parse(RetVal.data).RecvAmtWH);
                                    $("#off_recv_amt_dc").text(JSON.parse(RetVal.data).RecvAmtDC);
                                } else {
                                    $("#gatepass_bilty_noErr").text(RetVal.data);
                                    $("#gatepass_no").text("");
                                    $("#gatepass_date").text("");
                                    $("#party_name").text("");
                                    $("#gstin").text("");
                                    $("#weight").text("");
                                    $("#content").text("");
                                    $("#amount").text("");
                                    $("#amount_words").text("");
                                    $("#cash_cheque").text("");
                                    $("#cheque_no").text("");
                                    $("#booking_date").text("");
                                    $("#private_mark").text("");
                                    $("#wbn").text("");
                                    $("#no_pckg").text("");
                                    $("#bilty_no").text("");
                                    $("#cod_amt_wh").text("");
                                    $("#cod_amt_dc").text("");
                                    $("#cgst_wh").text("");
                                    $("#cgst_dc").text("");
                                    $("#sgst_wh").text("");
                                    $("#sgst_dc").text("");
                                    $("#discount_wh").text("");
                                    $("#discount_dc").text("");
                                    $("#tot_wh").text("");
                                    $("#tot_dc").text("");
                                    $("#cgst_p").text("");
                                    $("#sgst_p").text("");
                                    $("#recv_amt_wh").text("");
                                    $("#recv_amt_dc").text("");


                                    $("#off_gatepass_no").text("");
                                    $("#off_gatepass_date").text("");
                                    $("#off_weight").text("");
                                    $("#off_content").text("");
                                    $("#off_party_name").text("");
                                    $("#off_gstin").text("");
                                    $("#off_amount").text("");
                                    $("#off_amount_words").text("");
                                    $("#off_cash_cheque").text("");
                                    $("#off_cheque_no").text("");
                                    $("#off_booking_date").text("");
                                    $("#off_private_mark").text("");
                                    $("#off_wbn").text("");
                                    $("#off_no_pckg").text("");
                                    $("#off_bilty_no").text("");
                                    $("#off_cod_amt_wh").text("");
                                    $("#off_cod_amt_dc").text("");
                                    $("#off_cgst_wh").text("");
                                    $("#off_cgst_dc").text("");
                                    $("#off_sgst_wh").text("");
                                    $("#off_sgst_dc").text("");
                                    $("#off_discount_wh").text("");
                                    $("#off_discount_dc").text("");
                                    $("#off_tot_wh").text("");
                                    $("#off_tot_dc").text("");
                                    $("#off_cgst_p").text("");
                                    $("#off_sgst_p").text("");
                                    $("#off_recv_amt_wh").text("");
                                    $("#off_recv_amt_dc").text("");
                                }

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