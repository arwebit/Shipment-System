<?php
$pageName = "Gatepass, Payment and Goods Entry";
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
                                    <h5 class="card-title mb-0">Search Parties for Gatepass/Payments/Goods Entry</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" id="search" class="form-control" placeholder="Search by Party name, Party mobile">
                                        </div>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Party name</th>
                                                <th>Party mobile</th>
                                                <th>Party address</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody id="get_party_list">

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
<?php
if (isset($_REQUEST['party_id'])) {
    if (isset($_REQUEST['del_gatepass_id'])) {
        $gatepassID = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['del_gatepass_id'])));

        $deleteGatepassSQL = "DELETE FROM gatepass WHERE gatepass_id='$gatepassID'";
        $deleteLedgerSQL = "DELETE FROM ledger WHERE gatepass_id='$gatepassID'";

        if (mysqli_query($connection, $deleteGatepassSQL) && mysqli_query($connection, $deleteLedgerSQL)) {
            $message = "Successfully deleted";
            $className = "text-success";
        }
    }
    ?>
                    <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <?php

    $partyID = trim($_REQUEST['party_id']);
    $partyName = "";
    $sql = "SELECT * FROM party_list WHERE party_id='$partyID'";
    $query = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $partyName = $row['party_name'];
    }
    ?>
       <div class="card-header">
                                    <h5 class="card-title mb-0" style="float: left;">Gatepasss for Party : <?php echo $partyName; ?></h5>
                                    <a href="manage_gatepass.php?party_id=<?php echo $partyID; ?>">
                                    <button style="float: right;" class="btn btn-primary">Add</button></a>
                                 </div>

    <div class="card-body">
    <b class="<?php echo $className; ?>"><?php echo $message; ?></b>
<div class="table-responsive" style="height: 300px; overflow-y:scroll">
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th style="text-align:center" >Gatepass ID</th>
            <th style="text-align:center" >Bilty Number</th>
            <th style="text-align:center" >Delivery/Gatepass Date</th>
            <th style="text-align:center" >Package</th>
            <th style="text-align:center" >Weight (in kg)</th>
            <th style="text-align:center" >Option</th>
        </tr>

    </thead>
    <tbody>
        <?php
$gatepassSQL = "SELECT * FROM gatepass WHERE party_id = '$partyID'";
    $gatepassQuery = mysqli_query($connection, $gatepassSQL);
    while ($row = mysqli_fetch_assoc($gatepassQuery)) {
        $dueAmount = $row['due_amount'];
        ?>
        <tr>
            <td><?php echo $row['gatepass_id']; ?></td>
            <td><?php echo $row['bilty_no']; ?></td>
            <td><?php echo date("d-M-Y", strtotime($row['delivery_date'])); ?></td>
            <td><?php echo $row['package']; ?></td>
            <td><?php echo $row['weight']; ?></td>
            <td>
                <a href="manage_gatepass.php?gatepass_id=<?php echo $row['gatepass_id']; ?>">Edit</a> ||
                <a target="_blank" href="view_gatepass.php?gatepass_id=<?php echo $row['gatepass_id']; ?>">View</a> ||
                <a href="javascript:void(0)" onclick="confirmDeletion('<?php echo $row['gatepass_id']; ?>')">Delete</a>
            </td>
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

function confirmDeletion(id){
        let bool = confirm("Are you sure you want to delete the record ?");
        if(bool){
window.location.href="?party_id=<?php echo $partyID; ?>&&del_gatepass_id="+id;
        }
    }




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
                                $("#get_party_list").html(html);

                            },
                            error:function(a, b, c){
                                alert (`${a}, ${b}, ${c}`);
                            }
                        });
}
});

    });
</script>