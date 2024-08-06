<?php
$pageName = "Gatepass Report";
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
                                        <div class="col-lg-4">
                                        <label for="paty_name">Party Name <b class="text-danger">*
                                                                <?php echo $partyErr; ?>
                                                            </b></label>
                                            <select name="party_id" class="form-control" required>
                                            <option value="">Select party name</option>
                                                            <?php
$partySQL = "SELECT * FROM party_list";
$query = mysqli_query($connection, $partySQL);
while ($row = mysqli_fetch_assoc($query)) {
    ?>
                                                                <option value="<?php echo $row['party_id']; ?>" >
                                                                    <?php echo $row['party_name']; ?>
                                                                </option>
                                                                <?php
}?>

                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                        <label for="gatepass_from_date">Gatepass from date <b class="text-danger">*
                                                                <?php echo $fromDateErr; ?>
                                                            </b></label>
                                            <input type="date" name="gp_from_date" class="form-control" placeholder="From date" required>
                                        </div>

                                        <div class="col-lg-4">
                                        <label for="gatepass_to_date">Gatepass to date<b class="text-danger"> *
                                                                <?php echo $toDateErr; ?>
                                                            </b></label>
                                                            <input type="date" name="gp_to_date" class="form-control" placeholder="To date" required>
                                        </div>
                                      <div class="row" style="margin-top: 15px;">
                                      <div class="col-lg-4">
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
    $fromDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['gp_from_date'])));
    $toDate = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['gp_to_date'])));
    $partyID = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['party_id'])));

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
    if (empty($partyID)) {
        $partyErr = "Required";
        $error = 1;
    }
    ?>
                    <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">

        <?php
if ($error === 0) {
        $partyID = trim($_REQUEST['party_id']);
        $sql = "SELECT * FROM party_list WHERE party_id='$partyID'";
        $query = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $partyName = $row['party_name'];
            $partyMobile = $row['party_mobile'];
            $partyAddress = $row['party_address'];
        }

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
                    <b>Party Name :</b> <?php echo $partyName; ?><br />
                    <b>Party Mobile :</b> <?php echo $partyMobile; ?><br />
                    <b>Party Address :</b> <?php echo $partyAddress; ?>
                  </td>
                  <td style="width: 45%; padding-right: 20px; vertical-align:top">
                  <b>Report Generated :</b> From <?php echo date("d-m-Y", strtotime($fromDate)); ?> To <?php echo date("d-m-Y", strtotime($toDate)); ?><br />
                    <b>Printed on :</b> <?php echo date("d-m-Y"); ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
      <tr>
        <td colspan="2">
        <div style="text-align: center; font-size:20px; font-weight:bolder;">
                    GATEPASS LISTS
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
        <th style="text-align:center">Gatepass ID</th>
            <th style="text-align:center">Booking Code</th>
            <th style="text-align:center">Booking Date</th>
            <th style="text-align:center">Bilty Number</th>
            <th style="text-align:center">Delivery/Gatepass Date</th>
            <th style="text-align:center">No. of Packages</th>
            <th style="text-align:center">Weight (in kg)</th>
            <th style="text-align:center">To Pay (in  &#8377;)</th>
            <th style="text-align:center">Receive (in  &#8377;)</th>
            <th style="text-align:center">Rebate/Discount (in  &#8377;)</th>
        </tr>
    </thead>
    <tbody >
        <?php
$gatepassSQL = "SELECT * FROM gatepass WHERE party_id = '$partyID' AND delivery_date BETWEEN '$fromDate' AND '$toDate' ORDER BY delivery_date DESC";
        $gatepassQuery = mysqli_query($connection, $gatepassSQL);
        $balance = $obAsOnDate;
        while ($row = mysqli_fetch_assoc($gatepassQuery)) {
            ?>
        <tr>
           <td style="text-align:center"><?php echo $row['gatepass_id']; ?></td>
            <td style="text-align:center"><?php echo $row['booking_code']; ?></td>
            <td style="text-align:center"><?php echo date("d-M-Y", strtotime($row['booking_date'])); ?></td>
            <td style="text-align:center"><?php echo $row['bilty_no']; ?></td>
            <td style="text-align:center"><?php echo date("d-M-Y", strtotime($row['delivery_date'])); ?></td>
            <td style="text-align:center"><?php echo $row['package']; ?></td>
            <td style="text-align:center"><?php echo $row['weight']; ?></td>
            <td style="text-align:center"><?php echo $row['to_pay_amount']; ?></td>
            <td style="text-align:center"><?php echo $row['receive_amount']; ?></td>
            <td style="text-align:center"><?php echo $row['discount_amount']; ?></td>
        </tr>
        <?php
}
        ?>
     <tr>
</tr>
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