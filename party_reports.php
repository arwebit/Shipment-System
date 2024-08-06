<?php
$pageName = "Party Report";
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
        <td colspan="2">
        <div style="text-align: center; font-size:20px; font-weight:bolder;">
                    PARTY LISTS WITH THEIR DUES/EXCESS <br/>
                    <h6>Report generated till today</h6>
                </div>
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
        <tbody>
          <tr >
            <td style="padding: 30px 40px 0px 20px;">

            <table class="table table-bordered" style="width: 100%;">
    <thead>

        <tr>
        <th style="text-align:center">Party name</th>
            <th style="text-align:center">Party Mobile</th>
            <th style="text-align:center">Party Addess</th>
            <th style="text-align:center">Dues / Excess</th>
            <th style="text-align:center">Amount (in  &#8377;)</th>
        </tr>
    </thead>
    <tbody >
        <?php
$currentDate = date("Y-m-d");
$sql = "SELECT * FROM party_list";
$query = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($query)) {
    $partyID = $row['party_id'];
    $partyName = $row['party_name'];
    $partyMobile = $row['party_mobile'];
    $partyAddress = $row['party_address'];
    $openingBalance = $row['opening_balance'];

    $amountSQL = "SELECT SUM(debit) total_debit, SUM(credit) total_credit FROM ledger WHERE party_id='$partyID' AND transaction_date<='$currentDate'";
    $amountQuery = mysqli_query($connection, $amountSQL);
    $result = mysqli_fetch_assoc($amountQuery);
    $totalCredit = $result['total_credit'];
    $totalDebit = $result['total_debit'];
    $totalAmount = $openingBalance + $totalCredit - $totalDebit;

    if ($totalAmount < 0) {
        $paymentTag = "Exccess";
    } else if ($totalAmount > 0) {
        $paymentTag = "Due";
    } else {
        $paymentTag = "No Due/Excess";
    }

    ?>
        <tr>
           <td style="text-align:center"><?php echo $partyName; ?></td>
            <td style="text-align:center"><?php echo $partyMobile; ?></td>
            <td style="text-align:center"><?php echo $partyAddress; ?></td>
            <td style="text-align:center"><?php echo $paymentTag; ?></td>
            <td style="text-align:center"><?php echo abs($totalAmount); ?></td>
        </tr>

        <?php
}?>
    </tbody>
</table>
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