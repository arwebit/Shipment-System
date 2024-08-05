<?php
$pageName = "Profile";
require_once "./top.inc.php";

use Devker\Vaults\Vaults;


if (isset($_REQUEST['update_profile'])) {
    $error = 0;
    $fullName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['fullname'])));
    $userName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['username'])));

    if (empty($fullName)) {
        $fullNameErr = "Required";
        $error = 1;
    }

    if (empty($userName)) {
        $userNameErr = "Required";
        $error = 1;
    } else {
        $sql = "SELECT * FROM user_details WHERE user_id!='$userID' AND username = '$userName'";
        $query = mysqli_query($connection, $sql);
        $count = mysqli_num_rows($query);
        if ($count === 0) {
            $userNameErr = "Username exists";
            $error = 1;
        }
    }
    if ($error === 0) {
        $updateSQL = "UPDATE user_details SET username='$userName', full_name='$fullName' WHERE user_id='$userID'";
        if (mysqli_query($connection, $updateSQL)) {
            $passMessage = "Successfully updated profile";
            $className = "text-success";
            $error = 0;
        } else {
            $passMessage = "Server error";
            $className = "text-danger";
            $error = 1;
        }
    } else {
        $passMessage = "Recorrect errors";
        $className = "text-danger";
    }
}



if (isset($_REQUEST['password_change'])) {
    $error = 0;
    $oldPassword = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['old_password'])));
    $newPassword = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['new_password'])));

    if (empty($oldPassword)) {
        $oldPasswordErr = "Required";
        $error = 1;
    } else {
        $oldPassword = md5($oldPassword);
        $sql = "SELECT * FROM user_details WHERE user_id='$userID' AND password = '$oldPassword'";
        $query = mysqli_query($connection, $sql);
        $count = mysqli_num_rows($query);
        if ($count === 0) {
            $oldPasswordErr = "Old password doesnot matched";
            $error = 1;
        }
    }
    if (empty($newPassword)) {
        $newPasswordErr = "Required";
        $error = 1;
    } else {
        $newPassword = md5($newPassword);
    }
    if ($error === 0) {
        $updateSQL = "UPDATE user_details SET password='$newPassword' WHERE user_id='$userID'";
        if (mysqli_query($connection, $updateSQL)) {
            $passMessage = "Successfully changed password";
            $className = "text-success";
            $error = 0;
        } else {
            $passMessage = "Server error";
            $className = "text-danger";
            $error = 1;
        }
    } else {
        $passMessage = "Recorrect errors";
        $className = "text-danger";
    }
}


$sql = "SELECT * FROM user_details WHERE user_id='$userID'";
$query = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($query)) {
    $fullname = $row['full_name'];
    $username = $row['username'];
}
?>
<div class="wrapper">

    <?php require_once "./sidebar.inc.php"; ?>
    <div class="main">

        <?php require_once "./header.inc.php"; ?>
        <main class="content">
            <div class="container-fluid p-0">
                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Update Profile</h1>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="fullname">Full Name <b class="text-danger">*
                                                        <?php echo $fullNameErr; ?>
                                                    </b></label>
                                                <input type="text" tabindex="1" class="form-control" name="fullname" placeholder="Enter Full Name" value="<?php if ($error === 1) {
                                                                                                                                                                echo $fullName;
                                                                                                                                                            } else {
                                                                                                                                                                echo $fullname;
                                                                                                                                                            } ?>" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username">Username <b class="text-danger">* <?php echo $userNameErr; ?></b></label>
                                                <input type="text" tabindex="2" class="form-control" name="username" placeholder="Enter Username" value="<?php if ($error === 1) {
                                                                                                                                                                echo $userName;
                                                                                                                                                            } else {
                                                                                                                                                                echo $username;
                                                                                                                                                            } ?>" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" tabindex="3" name="update_profile">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="mb-3">
                            <h1 class="h3 d-inline align-middle">Change Password</h1>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <b class="<?php echo $className; ?>"><?php echo $passMessage; ?></b>
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="old_password">Old Password <b class="text-danger">* <?php echo $oldPasswordErr; ?></b></label>
                                                <input type="password" tabindex="4" class="form-control" name="old_password" placeholder="Enter Old Password" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="new_password">New Password <b class="text-danger">* <?php echo $newPasswordErr; ?></b></label>
                                                <input type="password" tabindex="5" class="form-control" name="new_password" placeholder="Enter New Password" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" tabindex="6" name="password_change">Change Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </main>

        <?php
        require_once "./footer.inc.php";
        ?>
    </div>
</div>

<?php
require_once "./bottom.inc.php";
?>