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

if (isset($_REQUEST['delete']) && isset($_REQUEST['party_id'])) {
    $partyID = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_id'])));
    $deleteGatepassSQL = "DELETE FROM gatepass WHERE party_id='$partyID'";
    $deleteLedgerSQL = "DELETE FROM ledger WHERE party_id='$partyID'";
    $deleteGoodsSQL = "DELETE FROM goods_list WHERE party_id='$partyID'";
    $deletePartySQL = "DELETE FROM party_list WHERE party_id='$partyID'";

    if (mysqli_query($connection, $deletePartySQL) || mysqli_query($connection, $deleteGatepassSQL) || mysqli_query($connection, $deleteLedgerSQL) || mysqli_query($connection, $deleteGoodsSQL)) {
        $message = "Successfully deleted";
        $className = "text-success";
        ?>
        <script>
            alert("Deleted party");
            window.location.href='manage_party.php';
        </script>
        <?php
}
}

if (isset($_REQUEST['party_id'])) {
    $partyid = trim($_REQUEST['party_id']);

    $error = 0;
    if (isset($_REQUEST['party_update'])) {
        $error = 0;
        $partyName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_name'])));
        $partyMobile = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_mobile'])));
        $partyAddress = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_address'])));
        $openingBalance = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['opening_balance'])));
        $status = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_status'])));

        if (empty($partyName)) {
            $partyNameErr = "Required";
            $error = 1;
        }
        if (empty($partyMobile) && $partyMobile != 0) {
            $partyMobileErr = "";
        } else {
            if (strlen($partyMobile) != 10 && $partyMobile != 0 && !empty($partyMobile)) {
                $partyMobileErr = "Must be 10 digits";
                $error = 1;
            }
        }
        if (empty($partyAddress)) {
            $partyAddressErr = "Required";
            $error = 1;
        }
        if (empty($openingBalance) && $openingBalance != 0) {
            $openingBalanceErr = "Required";
            $error = 1;
        }
        if (empty($status)) {
            $statusErr = "Required";
            $error = 1;
        }
        $currentDateTime = date("Y-m-d H:i:s");

        if ($error === 0) {
            $updateSQL = "UPDATE party_list SET party_mobile='$partyMobile', party_name='$partyName', party_address='$partyAddress', opening_balance='$openingBalance', is_active='$status', updated_by='$loginUserName', updated_date_time='$currentDateTime' WHERE party_id='$partyid'";

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
        $openingbalance = trim($row['opening_balance']);
        $isActive = $row['is_active'];
        $regDate = $row['created_date_time'];
    }
    ?>
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        Update party<br />
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
                                                        <label for="party_mobile">Party Mobile <b class="text-danger"> <?php echo $partyMobileErr; ?></b></label>
                                                        <input type="text" class="form-control" name="party_mobile" placeholder="Enter Party Mobile" value="<?php if ($error === 1) {
        echo $partyMobile;
    } else {echo $partymobile;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="party_address">Party Address <b class="text-danger">* <?php echo $partyAddressErr; ?></b></label>
                                                        <input type="text" class="form-control" name="party_address" placeholder="Enter Party Address" value="<?php if ($error === 1) {
        echo $partyAddress;
    } else {echo $partyaddress;}?>" />


                                                    </div>
                                                </div>

		 <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="opening_balance">Opening Balance Amount <small style="font-weight: bold;">(as on <?php echo date('d-M-Y', strtotime($regDate)); ?>)</small> <b class="text-danger">* <?php echo $openingBalanceErr; ?></b></label>
                                                        <input type="text" class="form-control number-field" name="opening_balance" placeholder="Enter Opening Balance Amount" value="<?php if ($error === 1) {
        echo $openingBalance;
    } else {echo $openingbalance;}?>" />
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
        $openingBalance = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['opening_balance'])));

        if (empty($partyName)) {
            $partyNameErr = "Required";
            $error = 1;
        }
        if (empty($partyMobile) && $partyMobile != 0) {
            $partyMobileErr = "";
        } else {
            if (strlen($partyMobile) != 10 && $partyMobile != 0) {
                $partyMobileErr = "Must be 10 digits";
                $error = 1;
            }
        }
        if (empty($partyAddress)) {
            $partyAddressErr = "Required";
            $error = 1;
        }

        if (empty($openingBalance) && $openingBalance != 0) {
            $openingBalanceErr = "Required";
            $error = 1;
        }

        $currentDateTime = date("Y-m-d H:i:s");

        if ($error === 0) {
            $insertSQL = "INSERT INTO party_list VALUES(DEFAULT, '$partyName', '$partyMobile', '$partyAddress','$openingBalance', 'active','$loginUserName', '$currentDateTime','',null)";
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
                                                        <label for="party_mobile">Party Mobile <b class="text-danger"> <?php echo $partyMobileErr; ?></b></label>
                                                        <input type="text" class="form-control" name="party_mobile" placeholder="Enter Party Mobile" value="<?php if ($error === 1) {
        echo $partyMobile;
    }?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="party_address">Party Address <b class="text-danger">* <?php echo $partyAddressErr; ?></b></label>
                                                        <input type="text" name="party_address" class="form-control" placeholder="Enter Party Address" value="<?php if ($error === 1) {
        echo nl2br($partyAddress);
    }?>">

                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="opening_balance">Opening Balance Amount <small style="font-weight: bold;">(as on <?php echo date('d-M-Y'); ?>)</small><b class="text-danger">* <?php echo $openingBalanceErr; ?></b></label>
                                                        <input type="text" class="form-control number-field" name="opening_balance" placeholder="Enter Opening Balance Amount" value="<?php if ($error === 1) {
        echo $openingBalance;
    } else {echo 0;}?>" />
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
                        </div>
                        <div class="row">
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
                                                <th>Opening Balance Amount (in &#8377;)</th>
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

function confirmDeletion(id){
        let bool = confirm("Are you sure you want to delete the record ?");
        if(bool){
window.location.href="?party_id="+id+"&&delete";
        }
    }


    $(document).ready(function() {
        $('.number-field').on('input', function() {
        var value = $(this).val();
        var valid = /^-?\d*\.?\d*$/.test(value);

        if (!valid) {
            $(this).val(value.slice(0, -1));
        }
    });


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