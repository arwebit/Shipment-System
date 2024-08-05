<?php
$pageName = "Manage Users";
require_once "./top.inc.php";

use Devker\Vaults\Vaults;
?>
<div class="wrapper">

    <?php require_once "./sidebar.inc.php";?>
    <div class="main">

        <?php require_once "./header.inc.php";?>
        <main class="content">
            <div class="container-fluid p-0">
                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle"><?php echo $pageName; ?></h1>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <?php
if (isset($_REQUEST['user_id'])) {
    $userid = trim($_REQUEST['user_id']);
    $error = 0;
    if (isset($_REQUEST['user_update'])) {
        $error = 0;
        $username = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['username'])));
        $fullname = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['fullname'])));
        $status = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['user_status'])));
        $role = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['user_role'])));

        if (empty($fullname)) {
            $fullNameErr = "Required";
            $error = 1;
        }
        if (empty($username)) {
            $userNameErr = "Required";
            $error = 1;
        } else {
            $sql = "SELECT * FROM user_details WHERE username='$username' AND user_id != '$userid'";
            $query = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($query);
            if ($count > 0) {
                $userNameErr = "Username exists, try another";
                $error = 1;
            }
        }
        if (empty($status)) {
            $statusErr = "Required";
            $error = 1;
        }
        if (empty($role)) {
            $roleErr = "Required";
            $error = 1;
        }

        if ($error === 0) {
            $insertSQL = "UPDATE user_details SET username='$username', full_name='$fullname', user_role='$role', is_active='$status' WHERE user_id='$userid'";
            if (mysqli_query($connection, $insertSQL)) {
                $message = "Successfully saved";
                $className = "text-success";
                $error = 0;
            } else {
                $message = "Server error";
                $className = "text-danger";
                $error = 1;
            }
        } else {
            $message = "Recorrect errors";
            $className = "text-danger";
        }
    }

    $fetchSQL = "SELECT * FROM user_details WHERE user_id='$userid'";
    $query = mysqli_query($connection, $fetchSQL);
    while ($row = mysqli_fetch_assoc($query)) {
        $fullName = $row['full_name'];
        $userName = $row['username'];
        $userRole = $row['user_role'];
        $isActive = $row['is_active'];
    }
    ?>
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        Update users<br />
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
                                                    <input type="text" class="form-control" name="fullname" placeholder="Enter Full Name" value="<?php if ($error === 1) {
        echo $fullname;
    } else {
        echo $fullName;
    }?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="username">Username <b class="text-danger">* <?php echo $userNameErr; ?></b></label>
                                                    <input type="text" class="form-control" name="username" placeholder="Enter Username" value="<?php if ($error === 1) {
        echo $username;
    } else {
        echo $userName;
    }?>" />
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="user_role">Role <b class="text-danger">* <?php echo $roleErr; ?></b></label>
                                                    <select name="user_role" class="form-control">
                                                        <option value="">Select role</option>
                                                        <?php
$roleSQL = "SELECT * FROM master_role";
    $query = mysqli_query($connection, $roleSQL);
    while ($row = mysqli_fetch_assoc($query)) {
        ?>
                                                            <option value="<?php echo $row['role_id']; ?>" <?php if ($error === 1) {
            if ($role === $row['role_id']) {
                echo 'selected';
            }
        } else {
            if ($userRole === $row['role_id']) {
                echo 'selected';
            }
        }?>>
                                                                <?php echo $row['role_name']; ?>
                                                            </option>
                                                        <?php
}?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="user_status">Status <b class="text-danger">* <?php echo $statusErr; ?></b></label>
                                                    <select name="user_status" class="form-control">
                                                        <option value="">Select status</option>
                                                        <?php
$statusArr = ['active', 'inactive'];
    foreach ($statusArr as $statusVal) {
        ?>
                                                            <option value="<?php echo $statusVal; ?>" <?php if ($error === 1) {
            if ($statusVal === $status) {
                echo 'selected';
            }
        } else {
            if ($isActive === $statusVal) {
                echo 'selected';
            }
        }?>>
                                                                <?php echo $statusVal; ?>
                                                            </option>
                                                        <?php
}?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="submit" name="user_update">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php
} else {
    if (isset($_REQUEST['user_save'])) {
        $error = 0;
        $username = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['username'])));
        $fullname = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['fullname'])));
        $password = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['password'])));
        $role = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['user_role'])));

        if (empty($fullname)) {
            $fullNameErr = "Required";
            $error = 1;
        }
        if (empty($username)) {
            $userNameErr = "Required";
            $error = 1;
        } else {
            $sql = "SELECT * FROM user_details WHERE username='$username'";
            $query = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($query);
            if ($count > 0) {
                $userNameErr = "Username exists, try another";
                $error = 1;
            }
        }
        if (empty($password)) {
            $passwordErr = "Required";
            $error = 1;
        } else {
            $password = md5($password);
        }
        if (empty($role)) {
            $roleErr = "Required";
            $error = 1;
        }

        if ($error === 0) {
            $insertSQL = "INSERT INTO user_details VALUES(DEFAULT, '$username', '$password', '$fullname', '$role','active')";
            if (mysqli_query($connection, $insertSQL)) {
                $message = "Successfully saved";
                $className = "text-success";
                $error = 0;
            } else {
                $message = "Server error";
                $className = "text-danger";
                $error = 1;
            }
        } else {
            $message = "Recorrect errors";
            $className = "text-danger";
        }
    }
    ?>
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            Add users<br />
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
                                                        <input type="text" class="form-control" name="fullname" placeholder="Enter Full Name" value="<?php if ($error === 1) {
        echo $fullname;
    }?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="username">Username <b class="text-danger">* <?php echo $userNameErr; ?></b></label>
                                                        <input type="text" class="form-control" name="username" placeholder="Enter Username" value="<?php if ($error === 1) {
        echo $username;
    }?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="password">Password <b class="text-danger">* <?php echo $passwordErr; ?></b></label>
                                                        <input type="password" class="form-control" name="password" placeholder="Enter Password" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="user_role">Role <b class="text-danger">* <?php echo $roleErr; ?></b></label>
                                                        <select name="user_role" class="form-control">
                                                            <option value="">Select role</option>
                                                            <?php
$roleSQL = "SELECT * FROM master_role";
    $query = mysqli_query($connection, $roleSQL);
    while ($row = mysqli_fetch_assoc($query)) {
        ?>
                                                                <option value="<?php echo $row['role_id']; ?>" <?php if ($role === $row['role_id']) {
            echo 'selected';
        }?>>
                                                                    <?php echo $row['role_name']; ?>
                                                                </option>
                                                            <?php
}?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary" type="submit" name="user_save">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php
}

?>
                                </div>
                        </div>
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">View Users</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
$userSQL = "SELECT * FROM user_details a INNER JOIN master_role b ON a.user_role=b.role_id WHERE username!='admin'";
$userQuery = mysqli_query($connection, $userSQL);
while ($row = mysqli_fetch_assoc($userQuery)) {
    ?>
                                                <tr>
                                                    <td><?php echo $row['full_name']; ?></td>
                                                    <td><?php echo $row['username']; ?></td>
                                                    <td><?php echo $row['role_name']; ?></td>
                                                    <td>
                                                        <span class="badge <?php echo $row['is_active'] === 'active' ? 'bg-success' : 'bg-danger' ?>">
                                                            <?php echo $row['is_active']; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="?user_id=<?php echo $row['user_id']; ?>">Edit</a>
                                                    </td>
                                                </tr>
                                            <?php
}?>
                                        </tbody>
                                    </table>
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