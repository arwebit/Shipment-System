<?php
$main_page = "Admin";
$page = "Add user";
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
                        <h2>ADD USERS</h2>
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
                                                <label>USERNAME</label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="ENTER USER NAME" />
                                                </div>
                                                <b class="text-danger" id="usernameErr"></b>
                                            </div>
                                            <div class="form-group">
                                                <label>NAME</label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="mem_name" id="mem_name" placeholder="ENTER MEMBER NAME" />
                                                </div>
                                                <b class="text-danger" id="mem_nameErr"></b>
                                            </div>

                                            <div class="form-group">
                                                <button type="button" name="add_user" id="add_user" class="btn btn-primary" onclick="add_user();">
                                                    SAVE
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>USER ROLE</label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <select name="user_role" id="user_role" class="form-control">
                                                        <option value="1" <?php
                                                        if ($payment_type == "1") {
                                                            echo "selected='selected'";
                                                        }
                                                        ?>>Admin</option>
                                                        <option value="2" <?php
                                                        if ($payment_type == "2") {
                                                            echo "selected='selected'";
                                                        }
                                                        ?>>Co-admin</option>
                                                        <option value="3" <?php
                                                        if ($payment_type == "3") {
                                                            echo "selected='selected'";
                                                        }
                                                        ?>>User</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>PASSWORD</label><span class="text-danger"> *</span>
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="user_pass" id="user_pass" placeholder="ENTER PASSWORD" />
                                                </div>
                                                <b class="text-danger" id="passwordErr"></b>
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
                function add_user() {
                    var login_user = "<?php echo $login_user; ?>";
                    var user_name = $("#user_name").val().trim();
                    var mem_name = $("#mem_name").val().trim();
                    var user_pass = $("#user_pass").val().trim();
                    var user_role = $("#user_role").val().trim();

                    if ((user_name === "") || (user_pass === "") || (mem_name === "") || (user_role === "")) {

                        $("#error_message").html("Provide all the fields<br/><br/>");

                        $('#usernameErr').text(user_name === "" ? "Required" : "");
                        $('#mem_nameErr').text(mem_name === "" ? "Required" : "");
                        $('#passwordErr').text(user_pass === "" ? "Required" : "");

                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?add_user",
                            dataType: "json",
                            data: {
                                login_user: login_user,
                                user_name: user_name,
                                mem_name: mem_name,
                                user_pass: user_pass,
                                user_role: user_role
                            },
                            success: function (RetVal) {
                                if (RetVal.message === "Success") {
                                    $("#success_message").html(RetVal.data + "<br/><br/>");
                                    $("#error_message").text("");
                                    $("#user_name").val("");
                                    $("#mem_name").val("");
                                    $("#user_pass").val("");
                                    $('#usernameErr').text("");
                                    $('#mem_nameErr').text("");
                                    $('#passwordErr').text("");
                                } else {
                                    $("#error_message").html(RetVal.message + "<br/><br/>");
                                    $("#success_message").text("");
                                    var usernameErr = JSON.parse(RetVal.data).UsernameErr;
                                    var mem_nameErr = JSON.parse(RetVal.data).Member_nameErr;
                                    var passwordErr = JSON.parse(RetVal.data).UserpassErr;

                                    if (usernameErr === null) {
                                        usernameErr = "";
                                    }
                                    if (mem_nameErr === null) {
                                        mem_nameErr = "";
                                    }
                                    if (passwordErr === null) {
                                        passwordErr = "";
                                    }

                                    $('#usernameErr').text(usernameErr);
                                    $('#mem_nameErr').text(mem_nameErr);
                                    $('#passwordErr').text(passwordErr);
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