<?php
$main_page = "Contents";
$page = "Add contents";
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
                        <h2>ADD CONTENTS</h2>
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
                                                <label>CONTENTS</label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="text" tabindex="1" class="form-control" name="contents" id="contents" placeholder="ENTER CONTENTS" />
                                                </div>
                                                <b class="text-danger" id="contentsErr"></b>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" tabindex="2" name="add_contents" id="add_contents" class="btn btn-primary" onclick="add_contents();">
                                                    SAVE
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
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
                function add_contents() {
                   var login_user = "<?php echo $login_user; ?>";
                    var contents = $("#contents").val().trim();

                    if ((contents === "")) {

                        $("#error_message").html("Provide all the fields<br/><br/>");

                        $('#contentsErr').text(contents === "" ? "Required" : "");

                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?add_contents",
                            dataType: "json",
                            data: {
                                login_user: login_user,
                                contents: contents
                            },
                            success: function (RetVal) {
                                if (RetVal.message === "Success") {
                                    $("#success_message").html(RetVal.data + "<br/><br/>");
                                    $("#error_message").text("");
                                    $("#contents").val("");
                                    $('#contentsErr').text("");
                                } else {
                                    $("#error_message").html(RetVal.message + "<br/><br/>");
                                    $("#success_message").text("");
                                    var contentsErr = JSON.parse(RetVal.data).ContentsErr;

                                    if (contentsErr === null) {
                                        contentsErr = "";
                                    }

                                    $('#contentsErr').text(contentsErr);
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