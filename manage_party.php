<?php
$pageName = "Manage Party";
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
if (isset($_REQUEST['party_id'])) {
    $partyid = trim($_REQUEST['party_id']);
    $error = 0;
    if (isset($_REQUEST['party_update'])) {
        $error = 0;
        $partyName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_name'])));
        $partyMobile = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_mobile'])));
        $partyAddress = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_address'])));
        $status = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_status'])));

        if (empty($partyName)) {
            $partyNameErr = "Required";
            $error = 1;
        }
        if (empty($partyMobile) && $partyMobile != 0) {
            $partyMobileErr = "Required";
            $error = 1;
        } else {
            if (strlen($partyMobile) != 10) {
                $partyMobileErr = "Must be 10 digits";
                $error = 1;
            } else {
                $sql = "SELECT * FROM party_list WHERE party_mobile='$partyMobile' AND party_id!='$partyid'";
                $query = mysqli_query($connection, $sql);
                $count = mysqli_num_rows($query);
                if ($count > 0) {
                    $partyMobileErr = "Mobile no. exists";
                    $error = 1;
                }
            }

        }
        if (empty($partyAddress)) {
            $partyAddressErr = "Required";
            $error = 1;
        }

        if (empty($status)) {
            $statusErr = "Required";
            $error = 1;
        }
        $currentDateTime = date("Y-m-d H:i:s");

        if ($error === 0) {
            $updateSQL = "UPDATE party_list SET party_mobile='$partyMobile', party_name='$partyName', party_address='$partyAddress', is_active='$status', updated_by='$loginUserName', updated_date_time='$currentDateTime' WHERE party_id='$partyid'";

            if (mysqli_query($connection, $updateSQL)) {
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

    $fetchSQL = "SELECT * FROM party_list WHERE party_id='$partyid'";
    $query = mysqli_query($connection, $fetchSQL);
    while ($row = mysqli_fetch_assoc($query)) {
        $partyname = $row['party_name'];
        $partymobile = $row['party_mobile'];
        $partyaddress = trim($row['party_address']);
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
                                        <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="party_name">Party Name <b class="text-danger">*
                                                                <?php echo $partyNameErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" name="party_name" placeholder="Enter Party Name" value="<?php if ($error === 1) {
        echo $partyName;
    } else {echo $partyname;}
    ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="party_mobile">Party Mobile <b class="text-danger">* <?php echo $partyMobileErr; ?></b></label>
                                                        <input type="number" class="form-control" name="party_mobile" placeholder="Enter Party Mobile" value="<?php if ($error === 1) {
        echo $partyMobile;
    } else {echo $partymobile;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="party_address">Party Address <b class="text-danger">* <?php echo $partyAddressErr; ?></b></label>
                                                        <textarea name="party_address" class="form-control" placeholder="Enter Party Address">
                                                            <?php if ($error === 1) {
        echo $partyAddress;
    } else {echo $partyaddress;}?>
                                                            </textarea>

                                                    </div>
                                                </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="party_status">Status <b class="text-danger">* <?php echo $statusErr; ?></b></label>
                                                    <select name="party_status" class="form-control">
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
                                                    <button class="btn btn-primary" type="submit" name="party_update">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php
} else {
    if (isset($_REQUEST['save_party'])) {
        $error = 0;
        $partyName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_name'])));
        $partyMobile = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_mobile'])));
        $partyAddress = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_address'])));

        if (empty($partyName)) {
            $partyNameErr = "Required";
            $error = 1;
        }
        if (empty($partyMobile) && $partyMobile != 0) {
            $partyMobileErr = "Required";
            $error = 1;
        } else {
            if (strlen($partyMobile) != 10) {
                $partyMobileErr = "Must be 10 digits";
                $error = 1;
            } else {
                $sql = "SELECT * FROM party_list WHERE party_mobile='$partyMobile'";
                $query = mysqli_query($connection, $sql);
                $count = mysqli_num_rows($query);
                if ($count > 0) {
                    $partyMobileErr = "Mobile no. exists";
                    $error = 1;
                }
            }

        }
        if (empty($partyAddress)) {
            $partyAddressErr = "Required";
            $error = 1;
        }
        $currentDateTime = date("Y-m-d H:i:s");
        if ($error === 0) {
            $insertSQL = "INSERT INTO party_list VALUES(DEFAULT, '$partyName', '$partyMobile', '$partyAddress', 'active','$loginUserName', '$currentDateTime','','')";
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
                                            Add party<br />
                                            <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="party_name">Party Name <b class="text-danger">*
                                                                <?php echo $partyNameErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" name="party_name" placeholder="Enter Party Name" value="<?php if ($error === 1) {
        echo $partyName;
    }?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="party_mobile">Party Mobile <b class="text-danger">* <?php echo $partyMobileErr; ?></b></label>
                                                        <input type="number" class="form-control" name="party_mobile" placeholder="Enter Party Mobile" value="<?php if ($error === 1) {
        echo $partyMobile;
    }?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="party_address">Party Address <b class="text-danger">* <?php echo $partyAddressErr; ?></b></label>
                                                        <textarea name="party_address" class="form-control" placeholder="Enter Party Address">
                                                            <?php if ($error === 1) {
        echo nl2br($partyAddress);
    }?>
                                                            </textarea>

                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary" type="submit" name="save_party">Save</button>
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
                                    <h5 class="card-title mb-0">View Parties</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" id="search" class="form-control" placeholder="Search by Party name, Party mobile">
                                        </div>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Party name</th>
                                                <th>Party mobile</th>
                                                <th>Party address</th>
                                                <th>Status</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody id="get_party_list">

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
<script>
    $(document).ready(function() {
$("#search").keyup(function(){
    let html="";
    let searchItem = $(this).val();
if(searchItem==="" || searchItem ===null){
    html="";
    $("#get_party_list").html(html);
}else{
    $.ajax({
                            type: "POST",
                            url: "ajax.php?search_party",
                            data: "search_item="+searchItem,
                            success: function (result) {
                                html=result;
                                console.log(html);
                                $("#get_party_list").html(html);

                            },
                            error:function(a, b, c){
                                alert (`${a}, ${b}, ${c}`);
                            }
                        });
}
});

    });
</script>