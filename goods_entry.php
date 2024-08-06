<?php
$pageName = "Goods entry";
require_once "./top.inc.php";

use Devker\Vaults\Vaults;
?>
<div class="wrapper">

    <?php require_once "./sidebar.inc.php";?>
    <div class="main">
        <?php require_once "./header.inc.php";?>
        <main class="content">
            <?php
if (isset($_REQUEST['party_id'])) {
    $partyID = trim($_REQUEST['party_id']);
    $partyName = "";
    $sql = "SELECT * FROM party_list WHERE party_id='$partyID'";
    $query = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $partyName = $row['party_name'];
    }

    if (isset($_REQUEST['del_goods_id'])) {
        $goodsID = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['del_goods_id'])));

        $deleteGoodsSQL = "DELETE FROM goods_list WHERE goods_id='$goodsID'";
        $deleteLedgerSQL = "DELETE FROM ledger WHERE goods_id='$goodsID'";

        if (mysqli_query($connection, $deleteGoodsSQL) && mysqli_query($connection, $deleteLedgerSQL)) {
            $message = "Successfully deleted";
            $className = "text-success";
        }

    }
    ?>
            <div class="container-fluid p-0">
                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Goods entry of Party : <?php echo $partyName; ?></h1>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <?php
if (!$_REQUEST['goods_id']) {
        $error = 0;
        if (isset($_REQUEST['entry_goods'])) {
            $error = 0;
            $goodsName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['goods_name'])));
            $totalAmount = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['total_amount'])));
            $sellDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['sell_date'])));

            if (empty($totalAmount) && $totalAmount != 0) {
                $totalAmountErr = "Required";
                $error = 1;
            } else {
                if ($totalAmount <= 0) {
                    $totalAmountErr = "Cannot be less than or equals to 0";
                    $error = 1;
                }
            }
            if (empty($goodsName)) {
                $goodsNameErr = "";
            } else {
                if (strlen($goodsName) > 255) {
                    $paymentRefNoErr = "Max : 255 characters";
                    $error = 1;
                }
            }

            if (empty($sellDate)) {
                $sellDateErr = "Required";
                $error = 1;
            } else {
                $sellDate = date("Y-m-d", strtotime($sellDate));
            }

            if ($error === 0) {
                $insertGoodsSQL = "INSERT INTO goods_list VALUES(DEFAULT,'$partyID','$goodsName','$totalAmount','$sellDate' )";

                if (mysqli_query($connection, $insertGoodsSQL)) {
                    $goodsID = mysqli_insert_id($connection);
                    $insertLedgerSQL = "INSERT INTO ledger VALUES(DEFAULT,'$partyID',NULL, '$goodsID',NULL, '$totalAmount',NULL,NULL, '$sellDate' )";

                    if (mysqli_query($connection, $insertLedgerSQL)) {
                        $message = "Successfully saved";
                        $className = "text-success";
                        $error = 0;
                    } else {
                        $message = "Ledger not saved";
                        $className = "text-danger";
                        $error = 1;
                    }
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
                                     Enter Goods<br />
                                        <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                    </h5>
                                </div>
                                <div class="card-body">

                                <form action="" method="post">
                                        <div class="row">
                                               <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="goods_name">Goods Name <b class="text-danger">
                                                               * <?php echo $goodsNameErr; ?>
                                                            </b></label>
                                                        <input type="text" tabindex="1" class="form-control"  name="goods_name" placeholder="Enter Goods Name" value="<?php if ($error == 1) {echo $goodsName;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="total_amount">Total Amount <b class="text-danger">*
                                                                <?php echo $totalAmountErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control number-field" tabindex="2" name="total_amount" placeholder="Enter Total Amount" value="<?php if ($error === 1) {
            echo $totalAmount;
        }
        ?>" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="sell_date">Sell Date<b class="text-danger">*
                                                                <?php echo $sellDateErr; ?>
                                                            </b></label>
                                                        <input type="date" tabindex="3" class="form-control" name="sell_date" placeholder="Enter Sell Date" value="<?php if ($error == 1) {echo date("Y-m-d", strtotime($sellDate));} else {echo date("Y-m-d");}?>"/>
                                                    </div>
                                                </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="submit" tabindex="4" name="entry_goods">Sell</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php
} else {
        $goodsID = $_REQUEST['goods_id'];
        if (isset($_REQUEST['update_goods'])) {
            $error = 0;
            $goodsName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['goods_name'])));
            $totalAmount = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['total_amount'])));
            $sellDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['sell_date'])));

            if (empty($totalAmount) && $totalAmount != 0) {
                $totalAmountErr = "Required";
                $error = 1;
            } else {
                if ($totalAmount <= 0) {
                    $totalAmountErr = "Cannot be less than or equals to 0";
                    $error = 1;
                }
            }
            if (empty($goodsName)) {
                $goodsNameErr = "";
            } else {
                if (strlen($goodsName) > 255) {
                    $paymentRefNoErr = "Max : 255 characters";
                    $error = 1;
                }
            }

            if (empty($sellDate)) {
                $sellDateErr = "Required";
                $error = 1;
            } else {
                $sellDate = date("Y-m-d", strtotime($sellDate));
            }

            if ($error === 0) {
                $updateGoodsSQL = "UPDATE goods_list SET goods_name ='$goodsName', total_amount='$totalAmount', sell_date='$sellDate' WHERE goods_id='$goodsID '";

                if (mysqli_query($connection, $updateGoodsSQL)) {
                    $updateLedgerSQL = "UPDATE ledger SET credit='$totalAmount', transaction_date='$sellDate' WHERE goods_id='$goodsID'";

                    if (mysqli_query($connection, $updateLedgerSQL)) {
                        $message = "Successfully updated";
                        $className = "text-success";
                        $error = 0;
                    } else {
                        $message = "Ledger not updated";
                        $className = "text-danger";
                        $error = 1;
                    }

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

        $goodsSQL = "SELECT * FROM goods_list WHERE goods_id='$goodsID'";
        $goodsQuery = mysqli_query($connection, $goodsSQL);
        while ($rowGoods = mysqli_fetch_assoc($goodsQuery)) {
            $fgoodsName = $rowGoods['goods_name'];
            $ftotalAmount = $rowGoods['total_amount'];
            $fsellDate = $rowGoods['sell_date'];
        }
        ?>
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                          Update goods list<br />
                                            <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                    <form action="" method="post">
                                        <div class="row">
                                        <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="goods_name">Goods Name <b class="text-danger">
                                                               * <?php echo $goodsNameErr; ?>
                                                            </b></label>
                                                        <input type="text" tabindex="1" class="form-control"  name="goods_name" placeholder="Enter Goods Name" value="<?php if ($error == 1) {echo $goodsName;} else {echo $fgoodsName;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="total_amount">Total Amount <b class="text-danger">*
                                                                <?php echo $totalAmountErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control number-field" tabindex="2" name="total_amount" placeholder="Enter Total Amount" value="<?php if ($error === 1) {
            echo $totalAmount;
        } else {echo $ftotalAmount;}
        ?>" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="sell_date">Sell Date<b class="text-danger">*
                                                                <?php echo $sellDateErr; ?>
                                                            </b></label>
                                                        <input type="date" tabindex="3" class="form-control" name="sell_date" placeholder="Enter Sell Date" value="<?php if ($error == 1) {echo date("Y-m-d", strtotime($sellDate));} else {echo date("Y-m-d", strtotime($fsellDate));}?>"/>
                                                    </div>
                                                </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="submit" tabindex="4" name="update_goods">Update</button>
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
                                    <h5 class="card-title mb-0">Goods List</h5>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive" style="height: 300px; overflow-y:scroll">
                                <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th>Date</th>
                                            <th>Goods name</th>
                                                <th>Total Amount (in &#8377;)</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>

    <?php
$goodsDetailsSQL = "SELECT * FROM goods_list WHERE party_id='$partyID' ORDER BY sell_date DESC";
    $goodsDetailsQuery = mysqli_query($connection, $goodsDetailsSQL);
    while ($rowGoodsDetails = mysqli_fetch_assoc($goodsDetailsQuery)) {
        ?>
        <tr>
        <td><?php echo date("d-m-Y", strtotime($rowGoodsDetails['sell_date'])); ?></td>
        <td><?php echo $rowGoodsDetails['goods_name']; ?></td>
        <td><?php echo $rowGoodsDetails['total_amount']; ?></td>
        <td><a href="?party_id=<?php echo $partyID; ?>&&goods_id=<?php echo $rowGoodsDetails['goods_id']; ?>">Edit</a> || <a href="javascript:void(0)" onclick="confirmDeletion('<?php echo $rowGoodsDetails['goods_id']; ?>')">Delete</a></td>
        </tr>
    <?php
}
    ?>

                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>

                        </div>
</div>
                </div>
                <?php
}?>
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
            window.location.href="?party_id=<?php echo $partyID; ?>&&del_goods_id="+id;
        }
    }
        $(document).ready(function(){
            $('.number-field').on('input', function() {
            // Allow: numbers, negative sign, decimal point
            var value = $(this).val();
            var valid = /^-?\d*\.?\d*$/.test(value);

            if (!valid) {
                $(this).val(value.slice(0, -1));
            }
        });
});
</script>