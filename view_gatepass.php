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
    <td style='text-align:left;font-size:12px;'><b>BILTY NO.:</b> $biltyNo</td>
    <td style='text-align:left;font-size:12px;'><b>GATEPASS ID:</b> $gatepassID</td>
       <td style='text-align:right;font-size:12px;'><b>DATED: </b>" . date("d/m/Y", strtotime($deliveryDate)) . "</td>
    </tr>
       <tr>
    <td style='text-align:left;font-size:12px;'><b>PARTY:</b> $partyName</td>
       <td colspan='2' style='text-align:left;font-size:12px;'><b>ADDRESS:</b>  $partyAddress </td>
    </tr>
    <tr>
    <td style='text-align:left;font-size:12px;'><b>GOODS:</b> $goodsName</td>
    <td style='text-align:left;font-size:12px;'><b>PACKAGES:</b> $packageNo NOS</td>
    <td style='text-align:left;font-size:12px;'><b>WEIGHT (in KG):</b> $weight</td>
    </tr>
    <tr>
    <td style='text-align:left;font-size:12px;'><b>To Pay:</b> &#8377;$toPayAmount</td>
    <td style='text-align:left;font-size:12px;'><b>Receive:</b> &#8377;$receiveAmount</td>
    <td style='text-align:left;font-size:12px;'><b>Discount:</b> &#8377;$discountAmount</td>
    </tr>

    </table>
    </div>


    <div class='footer'>

    </div>
    <div class='signature'>FOR $companyName</div>
  </div>";

$mpdf->WriteHTML($stylesheet, 1);
$mpdf->WriteHTML($pc, 2);

$mpdf->Output();
