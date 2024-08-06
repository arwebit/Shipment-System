<?php
$pageName = "User Manual";
require_once "./top.inc.php";
?>
<div class="wrapper">

    <?php require_once "./sidebar.inc.php";?>
    <div class="main">

        <?php require_once "./header.inc.php";?>
        <main class="content">
            <div class="container-fluid p-0">
 <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                            <button class="btn btn-info" onclick="printReport('printReport')">Print</button>
                            </div>
                            <div class="card-body">
                            <div id="printReport">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>
                                            <h3 style="font-weight: bold; text-align:center;">USER MANUAL</h3>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr >
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>
                                            <div style="margin:20px">

                             <p>
                             <b>A. Login</b>
                             <div>Default username : admin, Default password : admin</div>
                             </p>
                             <p>
                             <b>B. Master Section</b>
                             <div style="margin-left:10px;">
                                    <b>B.1. Users</b>
                                    <p style="margin-left:10px;">
                                    Admin can create users. There are two roles : <b>Admin</b> and <b>Manager</b>. <b>Admin</b> roles can access all the features, whereas <b>Manager</b> roles can accees all features except <b>Master Section</b>.
                                    </p>
                                    <b>B.2. Backup</b>
                                    <p style="margin-left:10px;">
                                    You can take backup of the database in <b>SQL file</b> for your future reference.
                                    </p>
                             </div>
                             </p>
                             <p>
<b>C. Party</b>
<div>Party details entry/edit/delete can be done. There are 4 (four) fields:
    <ol>
        <li>Party Name (Mandatory).</li>
        <li>Party Mobile (Optional). </li>
        <li>Party Address (Mandatory).</li>
        <li>Opening Balance (Mandatory).<br/>
<b>N.B.:</b>
<ul>
<li>The opening balance amount must be based on the date prior to the party's registration date.</li>
    <li>If there is no opening balance amount, put <b>0</b> in the field.</li>
    <li>Positive opening balance : Party has due amount.</li>
    <li>Negetive opening balance : Party paid excess amount.</li>
    <li>Please try to avoid changing the opening balance after entry, as it will effect the ledger accounts.</li>
</ul>

    </li>
    </ol>
</div>
                             </p>
                             <p>
                                <b>D. Gatepass, Payment and Goods Entry</b>
                                  <div style="margin-left:10px;">
                                    <b>D.1. Gatepass</b>
<p style="margin-left:10px;">
    After adding party, Gatepass entry/edit/delete can be done. First, search the party, and then click on <b>Gatepass</b>, and then <b>Add</b>. You can view all the gatepasses generated for that party and view a special gatepass id and take a print out of it for reference. There are 10 (ten) fields :
        <ol>
            <li>Booking Code (Mandatory).</li>
            <li>Booking Date (Optional). </li>
            <li>Bilty Number  (Mandatory).</li>
            <li>Deliver/Gatepass Date (Mandatory).</li>
            <li>Number of Packages (Mandatory).</li>
            <li>Weight (in kg) (Mandatory).</li>
            <li>Goods Name (Mandatory).</li>
            <li>To Pay Amount (Mandatory) -- The actual amount of gatepass.</li>
            <li>Receive Amount (Mandatory) -- The amount that has to be received from party. It must be less than or equals to <b>To Pay Amount</b>. This amount will reflect in the <b>Credit section</b> of party ledger.</li>
            <li>Discount/Rebate Amount (Mandatory) -- Automatically calculates based on <b>To Pay Amount</b> and <b>Receive Amount</b>. </li>
        </ol>
</p>

<b>D.2. Payment</b>
<p style="margin-left:10px;">
    After adding party, Payments entry/edit/delete can be done. First, search the party, and then click on <b>Payment</b>, and then <b>Add</b>. You can view all the payments generated for that party. There are 4 (four) fields :
        <ol>
            <li>Party Payment (Mandatory) -- Cannot be less than or equal to <b>0</b>.</li>
            <li>Payment Type (Mandatory). </li>
            <li>Payment Reference Number  (Optional).</li>
            <li>Payment Date (Mandatory) -- Default is current (today) date.</li>
        </ol>
</p>

<b>D.3. Goods Entry</b>
<p style="margin-left:10px;">
    After adding party, Goods entry/edit/delete can be done. First, search the party, and then click on <b>Goods</b> You can view all the payments generated for that party. There are 3 (three) fields :
        <ol>
            <li>Goods name (Mandatory).</li>
            <li>Total Amount (Mandatory) -- Cannot be less than or equal to <b>0</b>.</li>
            <li>Sell Date (Mandatory) -- Default is current (today) date.</li>
        </ol>
</p>

                                  </div>

                             </p>

                             <p>
                             <b>E. Reports</b>
                             <div style="margin-left:10px;">
                                    <b>E.1. Party Ledger Report</b>
                                    <p style="margin-left:10px;">
This is the party accounts report. It shows the party ledger. To generate the report, provide: <b>Party name</b>, <b>From Date</b> and <b>To Date</b>.
                                    </p>
                                    <b>E.2. Company Ledger Report</b>
                                    <p style="margin-left:10px;">
                                    This is the company accounts report. It shows the company ledger. To generate the report, provide: <b>From Date</b> and <b>To Date</b>.
                                    </p>
                                    <b>E.3. Gatepass Report</b>
                                    <p style="margin-left:10px;">
                                    This report shows the gatepasses generated. To generate the report, provide: <b>Party name</b>, <b>From Date</b> and <b>To Date</b>.
                                    </p>
                                    <b>E.4. Party Report</b>
                                    <p style="margin-left:10px;">
                                    This report shows all the party list along with their dues/excess amount till current date.
                                    </p>
                             </div>
                             </p>
                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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