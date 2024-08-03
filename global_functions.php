<?php
function getCompanyName(){
    $companyName="AMARJYOTI ROADLINK";
    return $companyName;
}
function get_address(){
    $address="";
    $address.="<center>";
    $address.="<h3>AMAR JYOTI ROADLINK(Code -137)</h3>";
    $address.="<b>Head Office : Unity Building, Sevoke Road, Siliguri - 734001<br/>";
    $address.="Admn. Office : No. 29, 3rd Floor, Khanna Mkt. Tis Hazari, Delhi-110054<br/>";
    $address.="Ph : 09310414563</b></center><br/>";
    return $address;
}
function getGST(){
    $gstName="19AKOPS4864Q1ZU";
    return $gstName;
}

function count_gp_ddr($gen_month){
    $sql="SELECT * FROM ddr_generation_gp WHERE gen_month='$gen_month'";
    $count= connect_db()->countEntries($sql);
    return $count;
}
function count_pb_ddr($gen_month){
    $sql="SELECT * FROM ddr_generation_pb WHERE gen_month='$gen_month'";
    $count= connect_db()->countEntries($sql);
    return $count;
}
?>