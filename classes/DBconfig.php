<?php

date_default_timezone_set("Asia/Kolkata");

function connect_db() {
    $dboperation = new DBOperation("localhost", "root", "", "shipment");
    return $dboperation;
}
function ret_json_str($sql) {
    $ret_val = json_encode(connect_db()->fetchData($sql));
    return $ret_val;
}

?>

