<?php
$main_page = "Contents";
$page = "Edit contents";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
    if ($_GET['cn_id']) {
        $cn_id = $_GET['cn_id'];
        $cnSQL = "SELECT * FROM mas_contents WHERE id='$cn_id'";
        $cn_fetch = json_decode(ret_json_str($cnSQL));
        foreach ($cn_fetch as $cn_val) {
            $contents_desc = $cn_val->contents_desc;
            $cn_status = $cn_val->status;
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
                            <h2>EDIT CONTENTS</h2>
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
                                                    <input type="text" tabindex="1" class="form-control" name="contents" id="contents" placeholder="ENTER CONTENTS" value="<?php echo $contents_desc;?>" />
                                                    <input type="hidden" class="form-control" name="hcontents" id="hcontents" placeholder="ENTER CONTENTS" value="<?php echo $contents_desc;?>" />
                                               </div>
                                                <b class="text-danger" id="contentsErr"></b>
                                            </div>

                                                <div class="form-group">
                                                    <button type="button" tabindex="3" name="edit_content" id="edit_content" class="btn btn-primary" onclick="edit_content();">
                                                        SAVE
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label>STATUS</label><span class="text-danger"></span>
                                                    <div class="form-line">
                                                        <select name="cn_status" tabindex="2" id="cn_status" class="form-control">
                                                            <option value="1" <?php
                                                            if ($cn_status == "1") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>ACTIVE</option>
                                                            <option value="0" <?php
                                                            if ($cn_status == "0") {
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
                    function edit_content() {
                        var login_user = "<?php echo $login_user; ?>";
                        var content_id = "<?php echo $cn_id; ?>";
                        var contents = $("#contents").val().trim();
                        var hcontents = $("#hcontents").val().trim();
                        var cn_status = $("#cn_status").val().trim();

                        if (contents === "") {
                            $("#error_message").html("Provide all the fields<br/><br/>");
                            $('#contentsErr').text(contents === "" ? "Required" : "");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "getAPI.php?edit_content",
                                dataType: "json",
                                data: {
                                    content_id: content_id,
                                    login_user: login_user,
                                    contents: contents,
                                    hcontents:hcontents,
                                    cn_status: cn_status
                                },
                                success: function (RetVal) {
                                    if (RetVal.message === "Success") {
                                        $("#success_message").html(RetVal.data + "<br/><br/>");
                                        $("#error_message").text("");
                                        $('#contentsErr').text("");
                                    } else {
                                        $("#error_message").html(RetVal.message + "<br/><br/>");
                                        $("#success_message").text("");
                                        var contentsErr = JSON.parse(RetVal.data).ContentsErr;

                                        if (contentsErr === null) {
                                            contentsErr = "";
                                        }
                                        $('#contentsErr').text("");
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
    }
} else {
    header("location:index.php");
}
?>