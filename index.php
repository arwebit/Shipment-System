<?php
$pageName = "Login";
session_start();
error_reporting(1);
require_once "./dbconnect.php";
require_once __DIR__ . "/vendor/autoload.php";

use Devker\Vaults\Vaults;

if (isset($_REQUEST['login'])) {
    $username = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['username'])));
    $password = mysqli_real_escape_string($connection, Vaults::removeHTMLEntities(trim($_REQUEST['password'])));
    $loginErr = "";
    $error = 0;

    if (empty($username)) {
        $usernameErr = "Required";
        $error = 1;
    }
    if (empty($password)) {
        $passwordErr = "Required";
        $error = 1;
    } else {
        $password = md5($password);
    }

    if ($error === 1) {
        $loginErr = "Provide all the fields";
    } else {
        $sql = "SELECT * FROM user_details WHERE username='$username' AND password = '$password'";
        $query = mysqli_query($connection, $sql);
        $count = mysqli_num_rows($query);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $_SESSION['SHIP_USER_ID'] = $row['user_id'];
                Vaults::redirectPage("home.php");
            }
        } else {
            $loginErr = "Wrong username and password";
        }
    }
}
?>
<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Ledger System | <?php echo $pageName; ?></title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

  </head>
  <body>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Shipment Ledger</span></div>
        <form action="" method="post">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
            <b class="error"><?php echo $usernameErr; ?></b>
          </div><br/>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
            <b class="error"><?php echo $passwordErr; ?></b>
          </div><br/>
          <div class="row button">
            <input type="submit" value="Login" name="login">
          </div>
          <b class="error"><?php echo $loginErr; ?></b>
        </form>
      </div>
    </div>

  </body>
</html>
