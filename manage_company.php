<?php
$pageName = "Manage Company";
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

if (isset($_REQUEST['delete']) && isset($_REQUEST['company_id'])) {
    $companyID = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['company_id'])));
    $deleteCompanyLedgerSQL = "DELETE FROM company_ledger WHERE company_id='$companyID'";
    $deleteCompanySQL = "DELETE FROM company_list WHERE company_id='$companyID'";

    if (mysqli_query($connection, $deleteCompanyLedgerSQL) || mysqli_query($connection, $deleteCompanySQL)) {
        $message = "Successfully deleted";
        $className = "text-success";
        ?>
        <script>
            alert("Deleted company");
            window.location.href='manage_company.php';
        </script>
        <?php
}
}

if (isset($_REQUEST['company_id'])) {
    $companyid = trim($_REQUEST['company_id']);

    $error = 0;
    if (isset($_REQUEST['company_update'])) {
        $error = 0;
        $companyName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['company_name'])));
        $companyMobile = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['company_mobile'])));
        $companyAddress = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['company_address'])));
        $openingBalance = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['opening_balance'])));
        $status = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['company_status'])));

        if (empty($companyName)) {
            $companyNameErr = "Required";
            $error = 1;
        }
        if (empty($companyMobile) && $companyMobile != 0) {
            $companyMobileErr = "";
        } else {
            if (strlen($companyMobile) != 10 && $companyMobile != 0 && !empty($companyMobile)) {
                $companyMobileErr = "Must be 10 digits";
                $error = 1;
            }
        }
        if (empty($companyAddress)) {
            $companyAddressErr = "Required";
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
            $updateSQL = "UPDATE company_list SET company_mobile='$companyMobile', company_name='$companyName', company_address='$companyAddress', opening_balance='$openingBalance', is_active='$status', updated_by='$loginUserName', updated_date_time='$currentDateTime' WHERE company_id='$companyid'";

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

    $fetchSQL = "SELECT * FROM company_list WHERE company_id='$companyid'";
    $query = mysqli_query($connection, $fetchSQL);
    while ($row = mysqli_fetch_assoc($query)) {
        $companyname = $row['company_name'];
        $companymobile = $row['company_mobile'];
        $companyaddress = trim($row['company_address']);
        $openingbalance = trim($row['opening_balance']);
        $isActive = $row['is_active'];
        $regDate = $row['created_date_time'];
    }
    ?>
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        Update company<br />
                                        <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                    </h5>
                                </div>
                                <div class="card-body">

                                    <form action="" method="post">
                                        <div class="row">
                                        <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="company_name">Company Name <b class="text-danger">*
                                                                <?php echo $companyNameErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name" value="<?php if ($error === 1) {
        echo $companyName;
    } else {echo $companyname;}
    ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="company_mobile">Company Mobile <b class="text-danger"> <?php echo $companyMobileErr; ?></b></label>
                                                        <input type="text" class="form-control" name="company_mobile" placeholder="Enter Company Mobile" value="<?php if ($error === 1) {
        echo $companyMobile;
    } else {echo $companymobile;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="company_address">Company Address <b class="text-danger">* <?php echo $companyAddressErr; ?></b></label>
                                                        <input type="text" class="form-control" name="company_address" placeholder="Enter Company Address" value="<?php if ($error === 1) {
        echo $companyAddress;
    } else {echo $companyaddress;}?>" />


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
                                                    <label for="company_status">Status <b class="text-danger">* <?php echo $statusErr; ?></b></label>
                                                    <select name="company_status" class="form-control">
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
                                                    <button class="btn btn-primary" type="submit" name="company_update">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php
} else {
    if (isset($_REQUEST['save_company'])) {
        $error = 0;
        $companyName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['company_name'])));
        $companyMobile = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['company_mobile'])));
        $companyAddress = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['company_address'])));
        $openingBalance = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['opening_balance'])));

        if (empty($companyName)) {
            $companyNameErr = "Required";
            $error = 1;
        }
        if (empty($companyMobile) && $companyMobile != 0) {
            $companyMobileErr = "";
        } else {
            if (strlen($companyMobile) != 10 && $companyMobile != 0) {
                $companyMobileErr = "Must be 10 digits";
                $error = 1;
            }
        }
        if (empty($companyAddress)) {
            $companyAddressErr = "Required";
            $error = 1;
        }

        if (empty($openingBalance) && $openingBalance != 0) {
            $openingBalanceErr = "Required";
            $error = 1;
        }

        $currentDateTime = date("Y-m-d H:i:s");

        if ($error === 0) {
            $insertSQL = "INSERT INTO company_list VALUES(DEFAULT, '$companyName', '$companyMobile', '$companyAddress','$openingBalance', 'active','$loginUserName', '$currentDateTime','',null)";
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
                                            Add company<br />
                                            <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="company_name">Company Name <b class="text-danger">*
                                                                <?php echo $companyNameErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name" value="<?php if ($error === 1) {
        echo $companyName;
    }?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="company_mobile">Company Mobile <b class="text-danger"> <?php echo $companyMobileErr; ?></b></label>
                                                        <input type="text" class="form-control" name="company_mobile" placeholder="Enter Company Mobile" value="<?php if ($error === 1) {
        echo $companyMobile;
    }?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="company_address">Company Address <b class="text-danger">* <?php echo $companyAddressErr; ?></b></label>
                                                        <input type="text" name="company_address" class="form-control" placeholder="Enter Company Address" value="<?php if ($error === 1) {
        echo nl2br($companyAddress);
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
                                                        <button class="btn btn-primary" type="submit" name="save_company">Save</button>
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
                                    <h5 class="card-title mb-0">View Companies</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" id="search" class="form-control" placeholder="Search by Company name, Company mobile">
                                        </div>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Company name</th>
                                                <th>Company mobile</th>
                                                <th>Company address</th>
                                                <th>Opening Balance Amount (in &#8377;)</th>
                                                <th>Status</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody id="get_company_list">

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
window.location.href="?company_id="+id+"&&delete";
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
    $("#get_company_list").html(html);
}else{
    $.ajax({
                            type: "POST",
                            url: "ajax.php?search_company",
                            data: "search_item="+searchItem,
                            success: function (result) {
                                html=result;
                                console.log(html);
                                $("#get_company_list").html(html);

                            },
                            error:function(a, b, c){
                                alert (`${a}, ${b}, ${c}`);
                            }
                        });
}
});

    });
</script>