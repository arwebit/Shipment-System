<?php
session_start();
error_reporting(1);
require_once "./dbconnect.php";
require_once __DIR__ . "/vendor/autoload.php";
require_once "./constants.php";

use Devker\Vaults\Vaults;

if ($_SESSION['SHIP_USER_ID'] === null || $_SESSION['SHIP_USER_ID'] === "" || empty($_SESSION['SHIP_USER_ID'])) {
    Vaults::redirectPage("index.php");
} else {
    $userID = $_SESSION['SHIP_USER_ID'];
    $roleSQL = "SELECT * FROM user_details WHERE user_id='$userID'";
    $query = mysqli_query($connection, $roleSQL);
    while ($row = mysqli_fetch_assoc($query)) {
        $loginFullName = $row['full_name'];
        $loginUserName = $row['username'];
        $loginUserRole = $row['user_role'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />


    <title>Shipment Ledger System | <?php echo $pageName; ?></title>

    <link href="css/app.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style type="text/css">

.header_image,
.footer_image {
  width: 100%;
}
.img_hidden {
    visibility: hidden;
  }

  div.report_footer{
    background-color: #cec9c9;
    visibility: hidden;
  }
  thead tr td.header_info{
    display: none;
    padding-bottom: 40px;
  }
  .header_color{
    background-color: #cec9c9;
  }
@media print {
  @page {
    size: A4;
    margin: 0;
  }

  body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .body_container {
    width: 102%;
    position: relative;
    margin-bottom: 150px;
  }

  .body_content {
    width: 100%;
    margin-top: 260px;
    page-break-after: always;
  }
  table td.border_right {
    border-right: 1px solid rgb(211, 208, 208);
  }

  .header_image {
    height: auto;
  }

  .footer_image {
    height: auto;
  }
  thead tr td.header_info{
    display: block;
  }
  .img_hidden {
    visibility: hidden;
  }
  div.report_footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: -1;
    visibility: visible;
  }

  table {
    page-break-inside: auto;
  }
  thead {
    display: table-header-group;
  }
  tfoot {
    display: table-footer-group;
  }
}

</style>
</head>

<body>