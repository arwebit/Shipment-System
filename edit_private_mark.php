<?php
$main_page = "Private mark";
$page = "Edit private mark";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
    if ($_GET['pm_id']) {
        $pm_id = $_GET['pm_id'];
        $pmSQL = "SELECT * FROM mas_private_mark WHERE id='$pm_id'";
        $pm_fetch = json_decode(ret_json_str($pmSQL));
        foreach ($pm_fetch as $pm_val) {
            $private_mark = $pm_val->private_mark;
            $party_name = $pm_val->party_name;
            $gstin_aadhar = $pm_val->gstin_aadhar;
            $pm_status = $pm_val->status;
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
                            <h2>EDIT PRIVATE MARK</h2>
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
                                                    <label>PRIVATE MARK</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="1" class="form-control" name="private_mark" id="private_mark" placeholder="ENTER PRIVATE MARK" value="<?php echo $private_mark; ?>" />
                                                        <input type="hidden" class="form-control" name="hprivate_mark" id="hprivate_mark" placeholder="ENTER PRIVATE MARK" value="<?php echo $private_mark; ?>"/>
                                                    </div>
                                                    <b class="text-danger" id="private_markErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>PARTY NAME</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="3" class="form-control" name="party_name" id="party_name" placeholder="ENTER PARTY NAME" value="<?php echo $party_name; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="party_nameErr"></b>
                                                </div>

                                                <div class="form-group">
                                                    <button type="button" tabindex="5" name="edit_private_mark" id="edit_private_mark" class="btn btn-primary" onclick="edit_private_mark();">
                                                        SAVE
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label>GSTIN / AADHAR</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" tabindex="2" class="form-control" name="gstin_aadhar" id="gstin_aadhar" placeholder="ENTER GSTIN / AADHAR" value="<?php echo $gstin_aadhar; ?>"/>
                                                    </div>
                                                    <b class="text-danger" id="gstin_aadharErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>STATUS</label><span class="text-danger"></span>
                                                    <div class="form-line">
                                                        <select name="pm_status" tabindex="4" id="pm_status" class="form-control">
                                                            <option value="1" <?php
                                                            if ($pm_status == "1") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>ACTIVE</option>
                                                            <option value="0" <?php
                                                            if ($pm_status == "0") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>IN-ACTIVE</option>
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
                    function edit_private_mark() {
                        var login_user = "<?php echo $login_user; ?>";
                        var private_id = "<?php echo $pm_id; ?>";
                        var private_mark = $("#private_mark").val().trim();
                        var hprivate_mark = $("#hprivate_mark").val().trim();
                        var party_name = $("#party_name").val().trim();
                        var gstin_aadhar = $("#gstin_aadhar").val().trim();
                        var pm_status = $("#pm_status").val().trim();

                        if ((private_mark === "") || (party_name === "") || (gstin_aadhar === "")) {
                            $("#error_message").html("Provide all the fields<br/><br/>");
                            $('#private_markErr').text(private_mark === "" ? "Required" : "");
                            $('#party_nameErr').text(party_name === "" ? "Required" : "");
                            $('#gstin_aadharErr').text(gstin_aadhar === "" ? "Required" : "");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "getAPI.php?edit_private_mark",
                                dataType: "json",
                                data: {
                                    private_id: private_id,
                                    login_user: login_user,
                                    private_mark: private_mark,
                                    hprivate_mark: hprivate_mark,
                                    party_name: party_name,
                                    gstin_aadhar: gstin_aadhar,
                                    pm_status: pm_status
                                },
                                success: function (RetVal) {
                                    if (RetVal.message === "Success") {
                                        $("#success_message").html(RetVal.data + "<br/><br/>");
                                        $("#error_message").text("");
                                        $('#private_markErr').text("");
                                        $('#party_nameErr').text("");
                                        $('#gstin_aadharErr').text("");
                                    } else {
                                        $("#error_message").html(RetVal.message + "<br/><br/>");
                                        $("#success_message").text("");
                                        var private_markErr = JSON.parse(RetVal.data).Private_markErr;
                                        var party_nameErr = JSON.parse(RetVal.data).Party_nameErr;
                                        var gstin_aadharErr = JSON.parse(RetVal.data).GSTINAadharErr;

                                        if (party_nameErr === null) {
                                            party_nameErr = "";
                                        }
                                        if (private_markErr === null) {
                                            private_markErr = "";
                                        }
                                        if (gstin_aadharErr === null) {
                                            gstin_aadharErr = "";
                                        }
                                        $('#party_nameErr').text("");
                                        $('#private_markErr').text("");
                                        $('#gstin_aadharErr').text("");
                                        $('#party_nameErr').text(party_nameErr);
                                        $('#private_markErr').text(private_markErr);
                                        $('#gstin_aadharErr').text(gstin_aadharErr);
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