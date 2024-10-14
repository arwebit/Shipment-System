<?php
require_once 'constants.php';
require_once 'dbconnect.php';
require_once __DIR__ . "/vendor/autoload.php";
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
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8',
    'format' => 'A5',
    'orientation' => 'P',
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 0,
    'margin_bottom' => 0]);
$stylesheet = file_get_contents('css/gatepass_receipt.css');
$pc = "<div class='receipt' style='margin-top:0px'>
    <div class='companyName'>$companyName</div>
    <div class='companyAddress'>
     $companyAddress $companyCityCountry - $companyPinCode<br />
      Mobile: $companyMobile GSTIN: $companyGSTIN
    </div>
    <div class='header'>
    <table width='100%' border='0' cellpadding='5px' cellspacing='0'>
    <tr>
    <td style='text-align:left'><b>BILTY NO.:</b> $biltyNo</td>
       <td style='text-align:right'><b>DATED: </b>" . date("d/m/Y", strtotime($deliveryDate)) . "</td>
    </tr>
       <tr>
    <td style='text-align:left'><b>PARTY NAME:</b> $partyName</td>
       <td style='text-align:right'><b>GATEPASS ID:</b> " . $gatepassID . "</td>
    </tr>
       <tr>
    <td style='text-align:left'><b>PARTY ADDRESS:</b>  $partyAddress </td>
     <td style='text-align:right'><b>PARTY MOBILE:</b>  $partyMobile </td>
    </tr>
    </table>
    </div>
    <table class='goodsTable'>
      <thead>
        <tr>
          <th>Particulars of Goods</th>
          <th>No. of Packages.</th>
          <th>Weight (Kg)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>$goodsName</td>
          <td style='text-align:center'>$packageNo</td>
          <td style='text-align:center'>$weight</td>
        </tr>
      </tbody>
    </table>
<table class='amounts_table' >
<tr>
<th style='text-align:left;'>To Pay :</th><td>&#8377;$toPayAmount</td>
<th style='text-align:right;'>Receive :</th><td>&#8377;$receiveAmount</td>
</tr>
<tr>
<th style='text-align:left;'>Discount :</th><td> &#8377;$discountAmount</td>
</tr>
</table>
    <div class='footer'>

    </div>
    <div class='signature'>FOR $companyName</div>
  </div>";

$oc = "<div class='receipt'>
    <div class='companyName'>$companyName</div>
    <div class='companyAddress'>
     $companyAddress $companyCityCountry - $companyPinCode<br />
      Mobile: $companyMobile GSTIN: $companyGSTIN
    </div>
    <div class='header'>
    <table width='100%' border='0' cellpadding='5px' cellspacing='0'>
    <tr>
    <td style='text-align:left'><b>BILTY NO.:</b> $biltyNo</td>
       <td style='text-align:right'><b>DATED: </b>" . date("d/m/Y", strtotime($deliveryDate)) . "</td>
    </tr>
       <tr>
    <td style='text-align:left'><b>PARTY NAME:</b> $partyName</td>
       <td style='text-align:right'><b>GATEPASS ID:</b> " . $gatepassID . "</td>
    </tr>
       <tr>
    <td style='text-align:left'><b>PARTY ADDRESS:</b>  $partyAddress </td>
     <td style='text-align:right'><b>PARTY MOBILE:</b>  $partyMobile </td>
    </tr>
    </table>
    </div>
    <table class='goodsTable'>
      <thead>
        <tr>
          <th>Particulars of Goods</th>
          <th>No. of Packages.</th>
          <th>Weight (Kg)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>$goodsName</td>
          <td style='text-align:center'>$packageNo</td>
          <td style='text-align:center'>$weight</td>
        </tr>
      </tbody>
    </table>
<table class='amounts_table' >
<tr>
<th style='text-align:left;'>To Pay :</th><td>&#8377;$toPayAmount</td>
<th style='text-align:right;'>Receive :</th><td>&#8377;$receiveAmount</td>
</tr>
<tr>
<th style='text-align:left;'>Discount :</th><td> &#8377;$discountAmount</td>
</tr>
</table>
    <div class='footer'>

    </div>
    <div class='signature'>FOR $companyName</div>
  </div>";
$mpdf->WriteHTML($stylesheet, 1);
$mpdf->WriteHTML($pc, 2);
$mpdf->WriteHTML("<br/>", 2);
$mpdf->WriteHTML($oc, 2);
$mpdf->Output();
