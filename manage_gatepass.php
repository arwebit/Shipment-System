<?php
$pageName = "Gatepass";
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
                <?php
if (isset($_REQUEST['party_id'])) {

    $partyID = trim($_REQUEST['party_id']);
    $partyName = "";
    $sql = "SELECT * FROM party_list WHERE party_id='$partyID'";
    $query = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $partyName = $row['party_name'];
    }

    if (isset($_REQUEST['generate_gatepass'])) {
        $error = 0;
        $viewGP = 0;
        $bookingCode = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['booking_code'])));
        $bookingDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['booking_date'])));
        $biltyNo = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['bilty_no'])));
        $deliverDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['deliver_date'])));
        $package = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['package'])));
        $weight = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['weight'])));
        $goodsName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['goods_name'])));
        $toPayAmount = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['to_pay_amount'])));
        $receiveAmount = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['receive_amount'])));
        $discountAmount = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['discount_amount'])));

        if (empty($bookingCode)) {
            $bookingCodeErr = "Required";
            $error = 1;
        } else {
            if (strlen($bookingCode) > 50) {
                $bookingCodeErr = "Max : 50 characters";
                $error = 1;
            }
        }
        if (empty($bookingDate)) {
            $bookingDateErr = "";
        } else {
            $bookingDate = date("Y-m-d", strtotime($bookingDate));
        }

        if (empty($biltyNo)) {
            $biltyNoErr = "Required";
            $error = 1;
        } else {
            if (strlen($biltyNo) > 50) {
                $biltyNoErr = "Max : 50 characters";
                $error = 1;
            }
        }
        if (empty($deliverDate)) {
            $deliverDateErr = "Required";
            $error = 1;
        } else {
            $deliverDate = date("Y-m-d", strtotime($deliverDate));
        }

        if (empty($package) && $package != 0) {
            $packageErr = "Required";
            $error = 1;
        } else {
            if (strlen($package) > 50) {
                $packageErr = "Max : 50 characters";
                $error = 1;
            }
        }
        if (empty($weight) && $weight != 0) {
            $weightErr = "Required";
            $error = 1;
        } else {
            if (strlen($weight) > 50) {
                $weightErr = "Max : 50 characters";
                $error = 1;
            }
        }
        if (empty($goodsName)) {
            $goodsNameErr = "Required";
            $error = 1;
        } else {
            if (strlen($goodsName) > 255) {
                $goodsNameErr = "Max : 255 characters";
                $error = 1;
            }
        }
        if (empty($toPayAmount) && $toPayAmount != 0) {
            $toPayAmountErr = "Required";
            $error = 1;
        }

        if (empty($discountAmount) && $discountAmount != 0) {
            $discountAmountErr = "Required";
            $error = 1;
        } else {
            if ($discountAmount < 0) {
                $discountAmountErr = "Cannot be negetive";
                $error = 1;
            }
        }
        if (empty($receiveAmount) && $receiveAmount != 0) {
            $receiveAmountErr = "Required";
            $error = 1;
        } else {
            if ($receiveAmount > $toPayAmount) {
                $receiveAmountErr = "Cannot be greater than To pay amount";
                $error = 1;
            }
        }

        if ($error === 0) {
            $insertgatepassSQL = "INSERT INTO gatepass VALUES(DEFAULT, '$partyID ', '$bookingCode', '$bookingDate', '$biltyNo', '$deliverDate', '$package', '$weight', '$goodsName', '$toPayAmount', '$discountAmount','$receiveAmount')";

            if (mysqli_query($connection, $insertgatepassSQL)) {
                $gatepassID = mysqli_insert_id($connection);
                $insertLedgerSQL = "INSERT INTO ledger VALUES(DEFAULT, '$partyID', '$gatepassID', NULL, NULL, '$receiveAmount', NULL,NULL, '$deliverDate')";
                if (mysqli_query($connection, $insertLedgerSQL)) {
                    $message = "Successfully saved";
                    $className = "text-success";
                    $error = 0;
                    $viewGP = 1;
                    $gpLink = "view_gatepass.php?gatepass_id=$gatepassID";
                } else {
                    $message = "Cannot save ledger";
                    $className = "text-danger";
                    $error = 1;
                    $viewGP = 0;
                }

            } else {
                $message = "Cannot save gatepass";
                $className = "text-danger";
                $error = 1;
                $viewGP = 0;
            }
        } else {
            $message = "Recorrect errors";
            $className = "text-danger";
        }
    }
    ?>
                        <div class="row">

                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Entry gatepass for party : <?php echo $partyName; ?></h5><br/>
                                    <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                </div>
                                <div class="card-body">
<form action="" method="post">
                                    <div class="row">
                                    <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="booking_code">Booking Code <b class="text-danger">*
                                                                <?php echo $bookingCodeErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" tabindex="1" name="booking_code" placeholder="Enter Booking Code" value="<?php if ($error == 1) {echo $bookingCode;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="booking_date">Booking Date <b class="text-danger">
                                                                <?php echo $bookingDateErr; ?>
                                                            </b></label>
                                                        <input type="date" class="form-control"  tabindex="2" name="booking_date" placeholder="Enter Booking Date" value="<?php if ($error == 1) {echo $bookingDate;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="bilty_no">Bilty Number <b class="text-danger">*
                                                                <?php echo $biltyNumberErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" name="bilty_no" tabindex="3" placeholder="Enter Bilty Number" value="<?php if ($error == 1) {echo $biltyNo;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="deliver_date">Deliver/Gatepass Date <b class="text-danger">*
                                                                <?php echo $deliverDateErr; ?>
                                                            </b></label>
                                                        <input type="date" class="form-control" tabindex="4" name="deliver_date" placeholder="Enter Deliver/Gatepass Date" value="<?php if ($error == 1) {echo $deliverDate;}?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="package">Number of Packages <b class="text-danger">*
                                                                <?php echo $packageErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control number-field" tabindex="5" name="package" placeholder="Enter Number of Packages" value="<?php if ($error == 1) {echo $package;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="weight">Weight (in kg)<b class="text-danger"> *
                                                                <?php echo $weightErr; ?>
                                                            </b></label>
                                                        <input type="text"  class="form-control number-field" tabindex="6" name="weight" placeholder="Enter Weight" value="<?php if ($error == 1) {echo $weight;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="goods_name">Goods Name <b class="text-danger">*
                                                                <?php echo $goodsNameErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" tabindex="7" name="goods_name" placeholder="Enter Goods Name" value="<?php if ($error == 1) {echo $goodsName;}?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="to_pay_amount">To Pay Amount <b class="text-danger">*
                                                                <?php echo $toPayAmountErr; ?>
                                                            </b></label>
                                                        <input type="text" id="to_pay_amt"  class="form-control number-field" tabindex="8" name="to_pay_amount" placeholder="Enter To Pay Amount" value="<?php if ($error == 1) {echo $toPayAmount;} else {echo 0;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="receive_amount">Receive Amount <b class="text-danger">*
                                                                <?php echo $receiveAmountErr; ?>
                                                            </b></label>
                                                        <input type="text" id="receive_amt"  class="form-control number-field" tabindex="9" name="receive_amount" placeholder="Enter Receive Amount" value="<?php if ($error == 1) {echo $receiveAmount;} else {echo 0;}?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="discount_amount">Discount/Rebate Amount <b class="text-danger">*
                                                                <?php echo $discountAmountErr; ?>
                                                            </b></label>
                                                        <input type="text" id="discount_amt" tabindex="10"  class="form-control number-field" name="discount_amount" placeholder="Enter Discount/Rebate Amount" value="<?php if ($error == 1) {echo $discountAmount;} else {echo 0;}?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button tabindex="11" type="submit" class="btn btn-primary" name="generate_gatepass">Generate Gatepass</button>
<?php
if ($viewGP === 1) {
        ?>
    <a href="<?php echo $gpLink; ?>" class="btn btn-warning">View Genrated Gatepass</a>
    <?php
}
    ?>

                                                </div>
                                    </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
} else {
    $gatepassID = $_REQUEST['gatepass_id'];

    if (isset($_REQUEST['update_gatepass'])) {
        $error = 0;
        $bookingCode = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['booking_code'])));
        $bookingDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['booking_date'])));
        $biltyNo = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['bilty_no'])));
        $deliverDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['deliver_date'])));
        $package = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['package'])));
        $weight = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['weight'])));
        $goodsName = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['goods_name'])));
        $toPayAmount = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['to_pay_amount'])));
        $receiveAmount = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['receive_amount'])));
        $discountAmount = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['discount_amount'])));

        if (empty($bookingCode)) {
            $bookingCodeErr = "Required";
            $error = 1;
        } else {
            if (strlen($bookingCode) > 50) {
                $bookingCodeErr = "Max : 50 characters";
                $error = 1;
            }
        }
        if (empty($bookingDate)) {
            $bookingDateErr = "";
        } else {
            $bookingDate = date("Y-m-d", strtotime($bookingDate));
        }
        if (empty($biltyNo)) {
            $biltyNoErr = "Required";
            $error = 1;
        } else {
            if (strlen($biltyNo) > 50) {
                $biltyNoErr = "Max : 50 characters";
                $error = 1;
            }
        }
        if (empty($deliverDate)) {
            $deliverDateErr = "Required";
            $error = 1;
        } else {
            $deliverDate = date("Y-m-d", strtotime($deliverDate));
        }

        if (empty($package) && $package != 0) {
            $packageErr = "Required";
            $error = 1;
        } else {
            if (strlen($package) > 50) {
                $packageErr = "Max : 50 characters";
                $error = 1;
            }
        }
        if (empty($weight) && $weight != 0) {
            $weightErr = "Required";
            $error = 1;
        } else {
            if (strlen($weight) > 50) {
                $weightErr = "Max : 50 characters";
                $error = 1;
            }
        }
        if (empty($goodsName)) {
            $goodsNameErr = "Required";
            $error = 1;
        } else {
            if (strlen($goodsName) > 255) {
                $goodsNameErr = "Max : 255 characters";
                $error = 1;
            }
        }
        if (empty($toPayAmount) && $toPayAmount != 0) {
            $toPayAmountErr = "Required";
            $error = 1;
        }
        if (empty($receiveAmount) && $receiveAmount != 0) {
            $receiveAmountErr = "Required";
            $error = 1;
        } else {
            if ($receiveAmount > $toPayAmount) {
                $receiveAmountErr = "Cannot be greater than To pay amount";
                $error = 1;
            }
        }
        if (empty($discountAmount) && $discountAmount != 0) {
            $discountAmountErr = "Required";
            $error = 1;
        } else {
            if ($discountAmount < 0) {
                $discountAmountErr = "Cannot be negetive";
                $error = 1;
            }
        }

        if ($error === 0) {
            $updateGatepassSQL = "UPDATE gatepass SET booking_code='$bookingCode', booking_date='$bookingDate',bilty_no='$biltyNo', delivery_date='$deliverDate', package='$package', weight='$weight', goods_name='$goodsName', to_pay_amount='$toPayAmount', receive_amount='$receiveAmount', discount_amount='$discountAmount' WHERE gatepass_id='$gatepassID'";

            if (mysqli_query($connection, $updateGatepassSQL)) {

                $updateLedgerSQL = "UPDATE ledger SET credit='$receiveAmount', transaction_date='$deliverDate' WHERE gatepass_id='$gatepassID'";

                if (mysqli_query($connection, $updateLedgerSQL)) {
                    $message = "Successfully updated";
                    $className = "text-success";
                    $error = 0;
                } else {
                    $message = "Cannot update ledger";
                    $className = "text-danger";
                    $error = 1;
                }
            } else {
                $message = "Cannot update gatepass";
                $className = "text-danger";
                $error = 1;
            }
        } else {
            $message = "Recorrect errors";
            $className = "text-danger";
        }
    }

    $partyName = "";
    $sql = "SELECT * FROM gatepass WHERE gatepass_id='$gatepassID'";
    $query = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $bookingcode = $row['booking_code'];
        $bookingdate = date("Y-m-d", strtotime($row['booking_date']));
        $biltyno = $row['bilty_no'];
        $deliverydate = date("Y-m-d", strtotime($row['delivery_date']));
        $packageno = $row['package'];
        $weightno = $row['weight'];
        $goodsname = $row['goods_name'];
        $topayamount = $row['to_pay_amount'];
        $receiveamount = $row['receive_amount'];
        $discountamount = $row['discount_amount'];
    }

    ?>
                        <div class="row">

                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Update gatepass ID : <?php echo $gatepassID; ?></h5><br/>
                                    <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                </div>
                                <div class="card-body">
<form action="" method="post">
                                    <div class="row">
                                    <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="booking_code">Booking Code <b class="text-danger">*
                                                                <?php echo $bookingCodeErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" tabindex="1" name="booking_code" placeholder="Enter Booking Code" value="<?php if ($error == 1) {echo $bookingCode;} else {echo $bookingcode;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="booking_date">Booking Date <b class="text-danger">
                                                                <?php echo $bookingDateErr; ?>
                                                            </b></label>
                                                        <input type="date" class="form-control"  tabindex="2" name="booking_date" placeholder="Enter Booking Date" value="<?php if ($error == 1) {echo $bookingDate;} else {echo $bookingdate;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="bilty_no">Bilty Number <b class="text-danger">*
                                                                <?php echo $biltyNumberErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" name="bilty_no" tabindex="3" placeholder="Enter Bilty Number" value="<?php if ($error == 1) {echo $biltyNo;} else {echo $biltyno;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="deliver_date">Deliver/Gatepass Date <b class="text-danger">*
                                                                <?php echo $deliverDateErr; ?>
                                                            </b></label>
                                                        <input type="date" class="form-control" tabindex="4" name="deliver_date" placeholder="Enter Deliver/Gatepass Date" value="<?php if ($error == 1) {echo $deliverDate;} else {echo $deliverydate;}?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="package">Number of Packages <b class="text-danger">*
                                                                <?php echo $packageErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control number-field" tabindex="5" name="package" placeholder="Enter Number of Packages" value="<?php if ($error == 1) {echo $package;} else {echo $packageno;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="weight">Weight (in kg)<b class="text-danger"> *
                                                                <?php echo $weightErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control number-field" tabindex="6" name="weight" placeholder="Enter Weight" value="<?php if ($error == 1) {echo $weight;} else {echo $weightno;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="goods_name">Goods Name <b class="text-danger">*
                                                                <?php echo $goodsNameErr; ?>
                                                            </b></label>
                                                        <input type="text" class="form-control" tabindex="7" name="goods_name" placeholder="Enter Goods Name" value="<?php if ($error == 1) {echo $goodsName;} else {echo $goodsname;}?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="to_pay_amount">To Pay Amount <b class="text-danger">*
                                                                <?php echo $toPayAmountErr; ?>
                                                            </b></label>
                                                        <input type="text" id="to_pay_amt" class="form-control number-field" tabindex="8" name="to_pay_amount" placeholder="Enter To Pay Amount" value="<?php if ($error == 1) {echo $toPayAmount;} else {echo $topayamount;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="receive_amount">Receive Amount <b class="text-danger">*
                                                                <?php echo $receiveAmountErr; ?>
                                                            </b></label>
                                                        <input type="text" id="receive_amt" class="form-control number-field" tabindex="9" name="receive_amount" placeholder="Enter Receive Amount" value="<?php if ($error == 1) {echo $receiveAmount;} else {echo $receiveamount;}?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="discount_amount">Discount/Rebate Amount <b class="text-danger">*
                                                                <?php echo $discountAmountErr; ?>
                                                            </b></label>
                                                        <input type="text" id="discount_amt" tabindex="10" class="form-control number-field" name="discount_amount" placeholder="Enter Discount/Rebate Amount" value="<?php if ($error == 1) {echo $discountAmount;} else {echo $discountamount;}?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button tabindex="11" type="submit" class="btn btn-primary" name="update_gatepass">Update Gatepass</button>
                                                </div>
                                    </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
}?>
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
    $(document).ready(function(){
        $('.number-field').on('input', function() {
        // Allow: numbers, negative sign, decimal point
        var value = $(this).val();
        var valid = /^-?\d*\.?\d*$/.test(value);

        if (!valid) {
            $(this).val(value.slice(0, -1));
        }
    });
      $("#to_pay_amt").keyup(function(){
        let toPayAmt = $(this).val();
        let receiveAmt = $("#receive_amt").val();
        let discountAmt = +toPayAmt - +receiveAmt;

        $("#discount_amt").val(discountAmt)
      });
      $("#receive_amt").keyup(function(){
        let toPayAmt =  $("#to_pay_amt").val();
        let receiveAmt =$(this).val();
        let discountAmt = +toPayAmt - +receiveAmt;

        $("#discount_amt").val(discountAmt)
      });
    });
</script>