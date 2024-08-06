<?php
$pageName = "Company Ledger Report";
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

                                <div class="card-body">
                                    <form action="" method="post">
                                    <div class="row">
                                        <div class="col-lg-6">
                                        <label for="from_date">From date <b class="text-danger">*
                                                                <?php echo $fromDateErr; ?>
                                                            </b></label>
                                            <input type="date" name="from_date" class="form-control" placeholder="From date" required>
                                        </div>

                                        <div class="col-lg-6">
                                        <label for="to_date">To date<b class="text-danger"> *
                                                                <?php echo $toDateErr; ?>
                                                            </b></label>
                                                            <input type="date" name="to_date" class="form-control" placeholder="To date" required>
                                        </div>
                                      <div class="row" style="margin-top: 15px;">
                                      <div class="col-lg-12">
                                            <button class="btn btn-primary" name="get_report" type="submit">Get report</button>
                                        </div>
                                      </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
<?php
if (isset($_REQUEST['get_report'])) {
    $error = 0;
    $fromDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['from_date'])));
    $toDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['to_date'])));

    if (empty($fromDate)) {
        $fromDateErr = "Required";
        $error = 1;
    } else {
        $fromDate = date("Y-m-d", strtotime($fromDate));
    }
    if (empty($toDate)) {
        $toDateErr = "Required";
        $error = 1;
    } else {
        $toDate = date("Y-m-d", strtotime($toDate));
    }

    ?>
                    <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">

        <?php
if ($error === 0) {
        $sql = "SELECT SUM(opening_balance) opening_balance FROM party_list";
        $query = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $openingBalance = $row['opening_balance'];
        }
        $sqlSum = "SELECT SUM(debit) AS debit, SUM(credit) AS credit FROM ledger WHERE transaction_date<'$fromDate'";
        $querySum = mysqli_query($connection, $sqlSum);
        while ($rowSum = mysqli_fetch_assoc($querySum)) {
            $debit = $rowSum['debit'];
            $credit = $rowSum['credit'];
        }

        $obAsOnDate = $openingBalance + $credit - $debit;
        ?>
         <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <button class="btn btn-info" onclick="printReport('printReport')">Print</button>
                                    </h5>
                                </div>
         <div class="card-body">
        <div id="printReport">
        <div class="body_container">
      <table style="width: 100%">
        <thead>
          <tr class="header_color">
            <td class="header_info">
                <div style="text-align: center;">
<h2><?php echo $companyName; ?></h2>
<h3><?php echo $companyAddress; ?>, <?php echo $companyCityCountry; ?>, Pin: <?php echo $companyPinCode; ?></h3>
<h5>Mobile: <?php echo $companyMobile; ?>, Email: <?php echo $companyEmail; ?></h5>
                </div>
            </td>
          </tr>
          <tr>
            <td>
              <table style="width: 100%">
                <tr class="table-info">
                  <td style="width: 50%; padding-left: 20px">
                  <b>Report Generated :</b> From <?php echo date("d-m-Y", strtotime($fromDate)); ?> To <?php echo date("d-m-Y", strtotime($toDate)); ?><br />
                    <b>Opening Balance (as on <?php echo date("d-m-Y", strtotime($fromDate)); ?>) : &#8377;</b><?php echo $obAsOnDate; ?> <br />

                  </td>
                  <td style="width: 45%; padding-right: 20px; vertical-align:top;">
                  <b>Printed on :</b> <?php echo date("d-m-Y"); ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td>
            <div style="visibility: hidden;">
            <div style="text-align: center;">&copy; <?php echo $companyCopyRight; ?></div>
         </div>
            </td>
          </tr>
        </tfoot>
        <!--  -->
        <tbody >
          <tr >
            <td style="padding: 30px 0px 0px 40px;">
            <table class="table table-bordered" style="width: 95%;">
    <thead>

        <tr>
            <th style="text-align:center">Date</th>
            <th style="text-align:center">Debit (in  &#8377;)</th>
            <th style="text-align:center">Credit (in  &#8377;)</th>
            <th style="text-align:center">Balance (in  &#8377;)</th>
        </tr>
<tr>
    <th colspan="3"> Opening balance as on <?php echo date("jS F, Y", strtotime($fromDate)) ?></th>
    <th style="text-align:center"><?php echo $obAsOnDate; ?> </th>
</tr>
    </thead>
    <tbody >
        <?php
$gatepassSQL = "SELECT * FROM ledger WHERE transaction_date BETWEEN '$fromDate' AND '$toDate' ORDER BY transaction_date";
        $gatepassQuery = mysqli_query($connection, $gatepassSQL);
        $balance = $obAsOnDate;
        while ($row = mysqli_fetch_assoc($gatepassQuery)) {

            $balance += $row['credit'] - $row['debit'];

            ?>
        <tr>

        <td><?php echo date("d-M-Y", strtotime($row['transaction_date'])); ?></td>
            <td style="text-align:center"><?php echo $row['debit']; ?></td>
            <td style="text-align:center"><?php echo $row['credit']; ?></td>
            <td style="text-align:center"><?php echo $balance; ?></td>
        </tr>
        <?php
}
        ?>
     <tr>

</tr>

    </tbody>
</table>
<br/>
<b> Closing balance as on <?php echo date("jS F, Y", strtotime($toDate)) ?> : &#8377; <?php echo $balance; ?>
</b><br/>
<b><?php echo $balance >= 0 ? "Company: $companyName has to recieve " : "Company: $companyName receive excess amount " ?> till <?php echo date("jS F, Y", strtotime($toDate)) ?> : &#8377;<?php echo abs($balance); ?>
</b>

            </td>
          </tr>
        </tbody>
        <!--  -->

        <div class="report_footer">
        <div style="text-align: center;">&copy; <?php echo $companyCopyRight; ?></div>
</div>
      </table>
    </div>
</div>
<?php
}
    ?>
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
                            url: "ajax.php?gatepass_party",
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

    function printReport(divID) {
    var printContents = document.getElementById(divID).innerHTML;
    var body = document.body;
    var originalContents = body.innerHTML;
    body.innerHTML = printContents;
    window.print();
    window.location.reload();
    body.innerHTML = originalContents;
  }
</script>