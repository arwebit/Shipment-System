<?php
require_once "./dbconnect.php";
require_once __DIR__ . "/vendor/autoload.php";

use Devker\Vaults\Vaults;

if (isset($_REQUEST['search_party'])) {
    $res = "";
    $searchItem = mysqli_real_escape_string($connection, trim($_REQUEST['search_item']));
    $sql = "SELECT * FROM party_list WHERE UPPER(party_name) LIKE '%" . strtoupper($searchItem) . "%' OR party_mobile LIKE '%$searchItem%'";
    $query = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $className = "";
        if ($row['is_active'] === 'active') {
            $className = "bg-success";
        } else {
            $className = "bg-danger";
        }
        $res .= "<tr>";
        $res .= "<td>" . $row['party_name'] . "</td>";
        $res .= "<td>" . $row['party_mobile'] . "</td>";
        $res .= "<td>" . nl2br($row['party_address']) . "</td>";
        $res .= "<td>" . nl2br($row['opening_balance']) . "</td>";
        $res .= "<td><span class='badge $className'>" . $row['is_active'] . "</span></td>";
        $res .= "<td>  <a href='?party_id=" . $row['party_id'] . "'>Edit</a> || <a href='javascript:void(0)' onclick=confirmDeletion('" . $row['party_id'] . "')>Delete</a></td>";
        $res .= "</tr>";
    }

    echo $res;
}

if (isset($_REQUEST['gatepass_party'])) {
    $res = "";
    $searchItem = mysqli_real_escape_string($connection, trim($_REQUEST['search_item']));
    $sql = "SELECT * FROM party_list WHERE (UPPER(party_name) LIKE '%" . strtoupper($searchItem) . "%' OR party_mobile LIKE '%$searchItem%') AND is_active='active'";
    $query = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $className = "";
        if ($row['is_active'] === 'active') {
            $className = "bg-success";
        } else {
            $className = "bg-danger";
        }
        $res .= "<tr>";
        $res .= "<td>" . $row['party_name'] . "</td>";
        $res .= "<td>" . $row['party_mobile'] . "</td>";
        $res .= "<td>" . nl2br($row['party_address']) . "</td>";
        $res .= "<td>  <a href='?party_id=" . $row['party_id'] . "'>Gatepass</a> || <a href='party_payment.php?party_id=" . $row['party_id'] . "'>Payment</a> || <a href='goods_entry.php?party_id=" . $row['party_id'] . "'>Goods entry</a></td>";
        $res .= "</tr>";
    }

    echo $res;
}
