<?php
$page = "Login";
include './global_functions.php';
?>﻿
<!DOCTYPE html>
<html>
    <head>
        <?php
        include './header_links.php';
        ?>
    </head>

    <body class="login-page">
        <div class="login-box">
            <div class="logo">
                <a href="javascript:void(0);">
                <?php echo getCompanyName(); ?>
                </a>
            </div>
            <div class="card">
                <div class="body">
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <div class="form-line">
                            <input type="text" tabindex="1" class="form-control" name="username" id="username" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <div class="form-line">
                            <input type="password" tabindex="2" class="form-control" name="password" id="userpass" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">

                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" tabindex="3" id="btn_login" type="button" onclick="login();">SIGN IN</button>
                        </div>
                    </div>
                    <b class="text-danger" id="login_error"></b>
                </div>
            </div>
        </div>

        <?php
        include './footer_links.php';
        ?>
        <script type="text/javascript">
            
            /* ***************************************** LOGIN STARTS ***************************************** */
            function login() {
                var username = $("#username").val().trim();
                var userpass = $("#userpass").val().trim();
                if ((username === "") || (userpass === "")) {
                    $("#login_error").text("Provide all the fields");
                } else {
                    $.ajax({
                        type: "POST",
                        url: "getAPI.php?admin_login",
                        dataType: "json",
                        data: {
                            username: username,
                            userpass: userpass
                        },
                        success: function (RetVal) {
                            if (RetVal.message === "Success") {
                                window.location.href = "home.php";
                            } else {
                                $("#login_error").text(RetVal.data);
                            }

                        }
                    });
                }
            }
            /* ***************************************** LOGIN ENDS ***************************************** */
        </script>
    </body>

</html>