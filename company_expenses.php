<?php
$pageName = "Company Expenses";
require_once "./top.inc.php";

use Devker\Vaults\Vaults;
?>
<div class="wrapper">

    <?php require_once "./sidebar.inc.php";?>
    <div class="main">
        <?php require_once "./header.inc.php";?>
        <main class="content">
            <?php
if (isset($_REQUEST['company_id'])) {
    $companyID = trim($_REQUEST['company_id']);
    $companyName = "";
    $sql = "SELECT * FROM company_list WHERE company_id='$companyID'";
    $query = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $companyName = $row['company_name'];
    }

    if (isset($_REQUEST['del_payment_id'])) {
        $paymentID = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['del_payment_id'])));

        $deleteLedgerSQL = "DELETE FROM company_ledger WHERE ledger_id='$paymentID'";

        if (mysqli_query($connection, $deleteLedgerSQL)) {
            $message = "Successfully deleted";
            $className = "text-success";
        }

    }
    ?>
            <div class="container-fluid p-0">
                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Expenses of company : <?php echo $companyName; ?></h1>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <?php
if (!$_REQUEST['ledger_id']) {
        $error = 0;
        if (isset($_REQUEST['company_payment'])) {
            $error = 0;
            $particulars = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['particulars'])));
            $debit = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['debit'])));
            $credit = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['credit'])));
            $transactionDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['transaction_date'])));

            if (empty($debit) && $debit != 0) {
                $debitErr = "Required";
                $error = 1;
            } else {
                if ($debit < 0) {
                    $debitErr = "Cannot be less than 0";
                    $error = 1;
                }
            }
            if (empty($credit) && $credit != 0) {
                $creditErr = "Required";
                $error = 1;
            } else {
                if ($credit < 0) {
                    $creditErr = "Cannot be less than 0";
                    $error = 1;
                }
            }
            if (empty($particulars)) {
                $particularsErr = "Required";
            } else {
                if (strlen($particulars) > 255) {
                    $particularsErr = "Max : 255 characters";
                    $error = 1;
                }
            }

            if (empty($transactionDate)) {
                $transactionDateErr = "Required";
                $error = 1;
            } else {
                $transactionDate = date("Y-m-d", strtotime($transactionDate));
            }

            if ($error === 0) {
                $insertSQL = "INSERT INTO company_ledger VALUES(DEFAULT,'$companyID', '$particulars', '$transactionDate', '$debit','$credit')";

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
                                     Enter expenses<br />
                                        <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
                                    </h5>
                                </div>
                                <div class="card-body">

                                <form action="" method="post">
                                        <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="particulars">Particulars <b class="text-danger">*
                                                                <?php echo $particularsErr; ?>
                                                            </b></label>
                                                        <input type="text"  class="form-control" tabindex="1" name="particulars" placeholder="Enter Particulars" value="<?php if ($error === 1) {
            echo $particulars;
        }
        ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment_type">Transaction Date <b class="text-danger">*
                                                                <?php echo $transactionDateErr; ?>
                                                            </b></label>
                                                            <input type="date" tabindex="4" class="form-control" name="transaction_date" placeholder="Enter Payment Date" value="<?php if ($error == 1) {echo date("Y-m-d", strtotime($paymentDate));} else {echo date("Y-m-d");}?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="debit">Debit <b class="text-danger">*
                                                                <?php echo $debitErr; ?>
                                                            </b></label>
                                                        <input type="text" tabindex="3" class="form-control  number-field"  name="debit" placeholder="Enter Debit" value="<?php if ($error == 1) {echo $debit;} else {echo "0";}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                <div class="form-group">
                                                        <label for="credit">Credit <b class="text-danger">*
                                                                <?php echo $creditErr; ?>
                                                            </b></label>
                                                        <input type="text" tabindex="4" class="form-control  number-field"  name="credit" placeholder="Enter Credit" value="<?php if ($error == 1) {echo $credit;} else {echo "0";}?>" />
                                                    </div>
                                                </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="submit" tabindex="5" name="company_payment">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php
} else {
        $companyLedgerID = $_REQUEST['ledger_id'];
        if (isset($_REQUEST['update_expenses'])) {
            $error = 0;
            $particulars = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['particulars'])));
            $debit = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['debit'])));
            $credit = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['credit'])));
            $transactionDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['transaction_date'])));

            if (empty($debit) && $debit != 0) {
                $debitErr = "Required";
                $error = 1;
            } else {
                if ($debit < 0) {
                    $debitErr = "Cannot be less than 0";
                    $error = 1;
                }
            }
            if (empty($credit) && $credit != 0) {
                $creditErr = "Required";
                $error = 1;
            } else {
                if ($credit < 0) {
                    $creditErr = "Cannot be less than 0";
                    $error = 1;
                }
            }
            if (empty($particulars)) {
                $particularsErr = "Required";
            } else {
                if (strlen($particulars) > 255) {
                    $particularsErr = "Max : 255 characters";
                    $error = 1;
                }
            }

            if (empty($transactionDate)) {
                $transactionDateErr = "Required";
                $error = 1;
            } else {
                $transactionDate = date("Y-m-d", strtotime($transactionDate));
            }
            if ($error === 0) {
                $updateSQL = "UPDATE company_ledger SET debit ='$payment', payment_type='$paymentType', payment_ref_no='$paymentRefNo', transaction_date='$paymentDate' WHERE ledger_id='$companyLedgerID '";

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

        $companyLedgerSQL = "SELECT * FROM company_ledger WHERE ledger_id='$companyLedgerID'";
        $companyLedgerQuery = mysqli_query($connection, $companyLedgerSQL);
        while ($rowLedger = mysqli_fetch_assoc($companyLedgerQuery)) {
            $fparticulars = $rowLedger['particulars'];
            $fdebit = $rowLedger['debit'];
            $fcredit = $rowLedger['credit'];
            $ftransactionDate = $rowLedger['transaction_date'];
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
                                                        <label for="particulars">Particulars <b class="text-danger">*
                                                                <?php echo $particularsErr; ?>
                                                            </b></label>
                                                        <input type="text"  class="form-control" tabindex="6" name="particulars" placeholder="Enter Particulars" value="<?php if ($error === 1) {
            echo $particulars;
        } else {echo $fparticulars;}
        ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="payment_type">Transaction Date <b class="text-danger">*
                                                                <?php echo $transactionDateErr; ?>
                                                            </b></label>
                                                            <input type="date" tabindex="7" class="form-control" name="transaction_date" placeholder="Enter Payment Date" value="<?php if ($error == 1) {echo date("Y-m-d", strtotime($paymentDate));} else {echo date("Y-m-d", strtotime($ftransactionDate));}?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="debit">Debit <b class="text-danger">*
                                                                <?php echo $debitErr; ?>
                                                            </b></label>
                                                        <input type="text" tabindex="8" class="form-control  number-field"  name="debit" placeholder="Enter Debit" value="<?php if ($error == 1) {echo $debit;} else {echo $fdebit;}?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                <div class="form-group">
                                                        <label for="credit">Credit <b class="text-danger">*
                                                                <?php echo $creditErr; ?>
                                                            </b></label>
                                                        <input type="text" tabindex="9" class="form-control  number-field"  name="credit" placeholder="Enter Credit" value="<?php if ($error == 1) {echo $credit;} else {echo $fcredit;}?>" />
                                                    </div>
                                                </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="submit" tabindex="10" name="update_expenses">Update</button>
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
                                    <h5 class="card-title mb-0">Expenses</h5>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive" style="height: 300px; overflow-y:scroll">
                                <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th>Date</th>
                                                <th>Debit (in &#8377;)</th>
                                                <th>Credit (in &#8377;)</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>

    <?php
$company_ledgerDetailsSQL = "SELECT * FROM company_ledger WHERE company_id='$companyID'";
    $company_ledgerDetailsQuery = mysqli_query($connection, $company_ledgerDetailsSQL);
    while ($rowLedgerDetails = mysqli_fetch_assoc($company_ledgerDetailsQuery)) {
        ?>
        <tr>
        <td><?php echo date("d-m-Y", strtotime($rowLedgerDetails['transaction_date'])); ?></td>
        <td><?php echo $rowLedgerDetails['debit']; ?></td>
        <td><?php echo $rowLedgerDetails['credit']; ?></td>
        <td><a href="?company_id=<?php echo $companyID; ?>&&ledger_id=<?php echo $rowLedgerDetails['ledger_id']; ?>">Edit</a> || <a href="javascript:void(0)" onclick="confirmDeletion('<?php echo $rowLedgerDetails['ledger_id']; ?>')">Delete</a></td>
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
            window.location.href="?company_id=<?php echo $companyID; ?>&&del_payment_id="+id;
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