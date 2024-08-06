<?php
$pageName = "View Gatepass";
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
                            <?php
if (isset($_REQUEST['gatepass_id'])) {
    $gatepassID = trim($_REQUEST['gatepass_id']);
    $gatepassSQL = "SELECT * FROM gatepass a INNER JOIN party_list b ON a.party_id=b.party_id WHERE a.gatepass_id = '$gatepassID'";
    $gatepassQuery = mysqli_query($connection, $gatepassSQL);
    while ($row = mysqli_fetch_assoc($gatepassQuery)) {
        $partyName = $row['party_name'];
        $partyMobile = $row['party_mobile'] == "0" ? "N/A" : $row['party_mobile'];
        $partyAddress = $row['party_address'];
        $bookingCode = $row['booking_code'];
        $bookingDate = $row['booking_date'];
        $biltyNo = $row['bilty_no'];
        $deliveryDate = $row['delivery_date'];
        $packageNo = $row['package'];
        $weight = $row['weight'];
        $goodsName = $row['goods_name'];
        $toPayAmount = $row['to_pay_amount'];
        $receiveAmount = $row['receive_amount'];
        $discountAmount = $row['discount_amount'];
    }
    ?>
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
            <td>
              <table style="width: 100%">
                <tr class="table-info">
                  <td style="width: 50%; padding-left: 20px">
                    <b>Party Name :</b> <?php echo $partyName; ?><br />
                    <b>Party Mobile :</b> <?php echo $partyMobile; ?><br />
                    <b>Party Address :</b> <?php echo $partyAddress; ?>
                  </td>
                  <td style="width: 45%; padding-right: 20px">
                    <b>Report Generated on :</b> <?php echo date("d-m-Y"); ?><br/>
                    <b>Gatepass ID :</b> <?php echo $gatepassID; ?><br/>
                    <b>Gatepass Date :</b> <?php echo date("jS F, Y", strtotime($deliveryDate)); ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </thead>
<tfoot>
    <tr>
        <th>
          <div style="float: right; margin-right:50px; margin-top:40px;">
            Signature
          </div>
        </th>
    </tr>
</tfoot>
        <tbody >
          <tr>
            <td style="padding: 30px 10px 0px 20px;">
           <table class="table table-bordered" style="width: 95%;">
            <tbody>
                <tr>
<td><b>Booking Code :</b> <?php echo $bookingCode; ?></td>
<td><b>Booking Date : </b><?php echo date("d/m/Y", strtotime($bookingDate)); ?></td>
<td><b>Bilty No. :</b> <?php echo $biltyNo; ?></td>
                </tr>
                <tr>
<td><b>No. of packages :</b> <?php echo $packageNo; ?></td>
<td><b>Weight : </b><?php echo $weight; ?> kg</td>
<td ><b>Goods Name :</b> <?php echo $goodsName; ?></td>
                </tr>
                <tr>
<td><b>To Pay amount :</b> &#8377;<?php echo $toPayAmount; ?></td>
<td><b>Receive Amount : </b> &#8377;<?php echo $receiveAmount; ?></td>
<td><b>Discount / Rebate Amount :</b> &#8377;<?php echo $discountAmount; ?></td>
                </tr>
            </tbody>
           </table>
            </td>
          </tr>
        </tbody>

      </table>
    </div>
</div>
                            </div>

                        </div>
                        <?php
}
?>
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