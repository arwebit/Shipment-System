<?php
session_start();
error_reporting(1);
require_once "./dbconnect.php";
require_once __DIR__ . "/vendor/autoload.php";

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

</head>

<body>