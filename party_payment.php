<?php
$pageName = "Party Payment";
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

    if (isset($_REQUEST['del_payment_id'])) {
        $paymentID = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['del_payment_id'])));

        $deleteLedgerSQL = "DELETE FROM ledger WHERE ledger_id='$paymentID'";

        if (mysqli_query($connection, $deleteLedgerSQL)) {
            $message = "Successfully deleted";
            $className = "text-success";
        }

    }
    ?>
            <div class="container-fluid p-0">
                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Payment of Party : <?php echo $partyName; ?></h1>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <?php
if (!$_REQUEST['ledger_id']) {
        $error = 0;
        if (isset($_REQUEST['party_payment'])) {
            $error = 0;
            $payment = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['payment'])));
            $paymentType = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['payment_type'])));
            $paymentRefNo = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['payment_ref_no'])));
            $paymentDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['payment_date'])));

            if (empty($payment) && $payment != 0) {
                $paymentErr = "Required";
                $error = 1;
            } else {
                if ($payment <= 0) {
                    $paymentErr = "Cannot be less than or equals to 0";
                    $error = 1;
                }
            }
            if (empty($paymentRefNo)) {
                $paymentRefNoErr = "";
            } else {
                if (strlen($paymentRefNo) > 100) {
                    $paymentRefNoErr = "Max : 100 characters";
                    $error = 1;
                }
            }

            if (empty($paymentType)) {
                $paymentTypeErr = "Required";
                $error = 1;
            } else {
                if (strlen($paymentType) > 50) {
                    $paymentTypeErr = "Max : 50 characters";
                    $error = 1;
                }
            }

            if (empty($paymentDate)) {
                $paymentDateErr = "Required";
                $error = 1;
            } else {
                $paymentDate = date("Y-m-d", strtotime($paymentDate));
            }

            if ($error === 0) {
                $insertSQL = "INSERT INTO ledger VALUES(DEFAULT,'$partyID',NULL, NULL, '$payment',NULL,'$paymentType','$paymentRefNo', '$paymentDate' )";

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
                                     Enter Payment<br />
                                        <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                    </h5>
                                </div>
                                <div class="card-body">

                                <form action="" method="post">
                                        <div class="row">
                                        <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment">Party Payment <b class="text-danger">*
                                                                <?php echo $paymentErr; ?>
                                                            </b></label>
                                                        <input type="text"  class="form-control number-field" tabindex="1" name="payment" placeholder="Enter Payment" value="<?php if ($error === 1) {
            echo $payment;
        }
        ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment_type">Payment Type <b class="text-danger">*
                                                                <?php echo $paymentTypeErr; ?>
                                                            </b></label>
                                                      <select name="payment_type" class="form-control" tabindex="2">
                                                        <option value="">Select Payment Type</option>
                                                        <?php
$payment = ["Online", "Cash", "UPI", "Cheque"];
        foreach ($payment as $payments) {
            ?>
                                                        <option value="<?php echo $payments; ?>" <?php if ($error == 1) {if ($payments == $paymentType) {echo "selected";}}?>><?php echo $payments; ?></option>
                                                          <?php
}
        ?>
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment_ref_no">Payment Reference Number <b class="text-danger">
                                                                <?php echo $paymentRefNoErr; ?>
                                                            </b></label>
                                                        <input type="text" tabindex="3" class="form-control"  name="payment_ref_no" placeholder="Enter Payment Reference Number" value="<?php if ($error == 1) {echo $paymentRefNo;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment_date">Payment Date<b class="text-danger">*
                                                                <?php echo $paymentDateErr; ?>
                                                            </b></label>
                                                        <input type="date" tabindex="4" class="form-control" name="payment_date" placeholder="Enter Payment Date" value="<?php if ($error == 1) {echo date("Y-m-d", strtotime($paymentDate));} else {echo date("Y-m-d");}?>"/>
                                                    </div>
                                                </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="submit" tabindex="4" name="party_payment">Payment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php
} else {
        $ledgerID = $_REQUEST['ledger_id'];
        if (isset($_REQUEST['update_payment'])) {
            $error = 0;
            $payment = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['payment'])));
            $paymentType = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['payment_type'])));
            $paymentRefNo = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['payment_ref_no'])));
            $paymentDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['payment_date'])));

            if (empty($payment) && $payment != 0) {
                $paymentErr = "Required";
                $error = 1;
            } else {
                if ($payment <= 0) {
                    $paymentErr = "Cannot be less than or equals to 0";
                    $error = 1;
                }
            }
            if (empty($paymentDate)) {
                $paymentDateErr = "Required";
                $error = 1;
            } else {
                $paymentDate = date("Y-m-d", strtotime($paymentDate));
            }

            if ($error === 0) {
                $updateSQL = "UPDATE ledger SET debit ='$payment', payment_type='$paymentType', payment_ref_no='$paymentRefNo', transaction_date='$paymentDate' WHERE ledger_id='$ledgerID '";

                if (mysqli_query($connection, $updateSQL)) {
                    $message = "Successfully updated";
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

        $fpayment = "";
        $ledgerSQL = "SELECT * FROM ledger WHERE ledger_id='$ledgerID'";
        $ledgerQuery = mysqli_query($connection, $ledgerSQL);
        while ($rowLedger = mysqli_fetch_assoc($ledgerQuery)) {
            $fpayment = $rowLedger['debit'];
            $fpaymentType = $rowLedger['payment_type'];
            $fpaymentRefNo = $rowLedger['payment_ref_no'];
            $fpaymentDate = $rowLedger['transaction_date'];
        }
        ?>
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                          Update payment<br />
                                            <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                    <form action="" method="post">
                                        <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment">Party Payment <b class="text-danger">*
                                                                <?php echo $paymentErr; ?>
                                                            </b></label>
                                                        <input type="text"  class="form-control number-field"  tabindex="1" name="payment" placeholder="Enter Payment" value="<?php if ($error === 1) {
            echo $payment;
        } else {
            echo $fpayment;
        }
        ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment_type">Payment Type <b class="text-danger">*
                                                                <?php echo $paymentTypeErr; ?>
                                                            </b></label>
                                                      <select name="payment_type" class="form-control" tabindex="2">
                                                        <option value="">Select Payment Type</option>
                                                        <?php
$payment = ["Online", "Cash", "UPI"];
        foreach ($payment as $payments) {
            ?>
                                                        <option value="<?php echo $payments; ?>" <?php if ($error == 1) {if ($payments == $paymentType) {echo "selected";}} else {if ($payments == $fpaymentType) {echo "selected";}}?>><?php echo $payments; ?></option>
                                                          <?php
}
        ?>
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment_ref_no">Payment Reference Number <b class="text-danger">
                                                                <?php echo $paymentRefNoErr; ?>
                                                            </b></label>
                                                        <input type="text" tabindex="3" class="form-control"  name="payment_ref_no" placeholder="Enter Payment Reference Number" value="<?php if ($error == 1) {echo $paymentRefNo;} else {echo $fpaymentRefNo;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment_date">Payment Date<b class="text-danger">*
                                                                <?php echo $paymentDateErr; ?>
                                                            </b></label>
                                                        <input type="date" tabindex="4" class="form-control" name="payment_date" placeholder="Enter Payment Date" value="<?php if ($error == 1) {echo date("Y-m-d", strtotime($paymentDate));} else {echo date("Y-m-d", strtotime($fpaymentDate));}?>"/>
                                                    </div>
                                                </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="submit"  tabindex="5" name="update_payment">Update Payment</button>
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
                                    <h5 class="card-title mb-0">Payments</h5>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive" style="height: 300px; overflow-y:scroll">
                                <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th>Date</th>
                                                <th>Payment (in &#8377;)</th>
                                                <th>Payment Type</th>
                                                <th>Payment Reference no.</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>

    <?php
$ledgerDetailsSQL = "SELECT * FROM ledger WHERE party_id='$partyID' AND debit IS NOT NULL";
    $ledgerDetailsQuery = mysqli_query($connection, $ledgerDetailsSQL);
    while ($rowLedgerDetails = mysqli_fetch_assoc($ledgerDetailsQuery)) {
        ?>
        <tr>
        <td><?php echo date("d-m-Y", strtotime($rowLedgerDetails['transaction_date'])); ?></td>
        <td><?php echo $rowLedgerDetails['debit']; ?></td>
        <td><?php echo $rowLedgerDetails['payment_type']; ?></td>
        <td><?php echo $rowLedgerDetails['payment_ref_no']; ?></td>
        <td><a href="?party_id=<?php echo $partyID; ?>&&ledger_id=<?php echo $rowLedgerDetails['ledger_id']; ?>">Edit</a> || <a href="javascript:void(0)" onclick="confirmDeletion('<?php echo $rowLedgerDetails['ledger_id']; ?>')">Delete</a></td>
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
            window.location.href="?party_id=<?php echo $partyID; ?>&&del_payment_id="+id;
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