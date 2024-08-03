<?php
$main_page = "Change password";
$page = "Change password";
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
                        <h2>CHANGE PASSWORD</h2>
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
                                                <label>OLD PASSWORD</label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="old_pass" id="old_pass" placeholder="ENTER PASSWORD" />
                                                </div>
                                                <b class="text-danger" id="old_passErr"></b>
                                            </div>

                                            <div class="form-group">
                                                <button type="button" name="change_pass" id="change_pass" class="btn btn-primary" onclick="change_pass();">
                                                    CHANGE PASSWORD
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>NEW PASSWORD</label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="ENTER PASSWORD" />
                                                </div>
                                                <b class="text-danger" id="new_passErr"></b>
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
                function change_pass() {
                    var login_user = "<?php echo $login_user; ?>";
                    var old_pass = $("#old_pass").val().trim();
                    var new_pass = $("#new_pass").val().trim();

                    if ((new_pass === "") || (old_pass === "")) {
                        $("#error_message").html("Provide all the fields<br/><br/>");
                        $('#old_passErr').text("Required");
                        $('#new_passErr').text("Required");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?change_pass",
                            dataType: "json",
                            data: {
                                login_user: login_user,
                                old_pass: old_pass,
                                new_pass: new_pass
                            },
                            success: function (RetVal) {
                                if (RetVal.message === "Success") {
                                    $("#success_message").html(RetVal.data + "<br/><br/>");
                                    $("#error_message").text("");
                                    $('#old_passErr').text("");
                                    $('#new_passErr').text("");
                                    $('#old_pass').val("");
                                    $('#new_pass').val("");
                                } else {
                                    $("#error_message").html(RetVal.message + "<br/><br/>");
                                    $("#success_message").text("");
                                    var old_passErr = JSON.parse(RetVal.data).OldpassErr;
                                    var new_passErr = JSON.parse(RetVal.data).NewpassErr;

                                    if (old_passErr === null) {
                                        old_passErr = "";
                                    }
                                    if (new_passErr === null) {
                                        new_passErr = "";
                                    }
                                    $('#old_passErr').text(old_passErr);
                                    $('#new_passErr').text(new_passErr);
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