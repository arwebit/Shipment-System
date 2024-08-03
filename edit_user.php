<?php
$main_page = "Admin";
$page = "Edit user";
include './file_includes.php';
if ($_SESSION['shipment_user']) {
    $login_user = $_SESSION['shipment_user'];
    if ($_GET['user_id']) {
        $user_id = $_GET['user_id'];
        $userSQL = "SELECT * FROM admin_login_access WHERE id='$user_id'";
        $user_fetch = json_decode(ret_json_str($userSQL));
        foreach ($user_fetch as $user_val) {
            $user_status = $user_val->status;
            $login_name = $user_val->name;
            $role_id = $user_val->role;
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
                            <h2>EDIT USER</h2>
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
                                                    <label>NAME</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="login_name" id="login_name" placeholder="ENTER LOGIN NAME" value="<?php echo $login_name; ?>" />
                                                    </div>
                                                    <b class="text-danger" id="login_nameErr"></b>
                                                </div>
                                                <div class="form-group">
                                                    <label>STATUS</label><span class="text-danger"></span>
                                                    <div class="form-line">
                                                        <select name="user_status" id="user_status" class="form-control">
                                                            <option value="1" <?php
                                                            if ($user_status == "1") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>ACTIVE</option>
                                                            <option value="0" <?php
                                                            if ($user_status == "0") {
                                                                echo "selected='selected'";
                                                            }
                                                            ?>>IN-ACTIVE</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <button type="button" name="edit_user" id="edit_user" class="btn btn-primary" onclick="edit_user();">
                                                        SAVE
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>ROLE</label><span class="text-danger"> *</span>
                                                    <div class="form-line">
                                                        <select name="role_id" id="role_id" class="form-control">
                                                            <option value="1" <?php
                                                                    if ($role_id == "1") {
                                                                        echo "selected='selected'";
                                                                    }
                                                                    ?>>ADMIN</option>
                                                            <option value="2" <?php
                                                    if ($role_id == "2") {
                                                        echo "selected='selected'";
                                                    }
                                                    ?>>CO-ADMIN</option>
                                                            <option value="3" <?php
                                                    if ($role_id == "3") {
                                                        echo "selected='selected'";
                                                    }
                                                    ?>>USER</option>
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
                    function edit_user() {
                        var login_user = "<?php echo $login_user; ?>";
                        var user_id = "<?php echo $user_id; ?>";
                        var user_status = $("#user_status").val().trim();
                        var login_name = $("#login_name").val().trim();
                        var role_id = $("#role_id").val().trim();
                        
                        if ((login_name === "")) {
                            $("#error_message").html("Provide all the fields<br/><br/>");
                            $('#login_nameErr').text("Required");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "getAPI.php?edit_user",
                                dataType: "json",
                                data: {
                                    user_id: user_id,
                                    login_user: login_user,
                                    login_name: login_name,
                                    user_status: user_status,
                                    user_role: role_id
                                },
                                success: function (RetVal) {
                                    if (RetVal.message === "Success") {
                                        $("#success_message").html(RetVal.data + "<br/><br/>");
                                        $("#error_message").text("");
                                         $('#login_nameErr').text("");
                                    } else {
                                        $("#error_message").html(RetVal.message + "<br/><br/>");
                                        $("#success_message").text("");
                                        var login_nameErr = JSON.parse(RetVal.data).Login_nameErr;
                                        
                                        if (login_nameErr === null) {
                                            login_nameErr = "";
                                        }
                                        $('#login_nameErr').text("");
                                        $('#login_nameErr').text(login_nameErr);
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