<?php
include './file_includes.php';
    if ($_GET['branch_despatch_id']) {
        $despatch_id = $_GET['branch_despatch_id'];
        $despatchDelSQL = "DELETE FROM branch_despatch WHERE id='$despatch_id'";
        $despatchDelStatus= connect_db()->cud($despatchDelSQL);
        header("location:view_branch_despatch_entry.php");
    }

?>