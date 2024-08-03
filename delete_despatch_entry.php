<?php

include './file_includes.php';
if ($_GET['despatch_id']) {
    $despatch_id = $_GET['despatch_id'];
    $despatchDelSQL = "DELETE FROM despatch WHERE id='$despatch_id'";
    $gpDelSQL = "DELETE FROM gatepass WHERE despatch_id='$despatch_id'";
    $despatchDelStatus = connect_db()->cud($despatchDelSQL);
    $gpDelStatus = connect_db()->cud($gpDelSQL);
    if (($despatchDelStatus == true) || ($gpDelStatus == true)) {
        header("location:view_despatch_entry.php");
    }
}
?>