<?php
session_start();
include ("db_connect.php");
include 'function.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $cashierUser = $_POST['user'];
  $cashierPass = $_POST['pass'];
  if (!empty($cashierUser) && !empty($cashierPass)) {
    $sqlCashier = "SELECT * from cashier WHERE user='$cashierUser' AND password='$cashierPass' ";
    $result = mysqli_query($conn, $sqlCashier);

    if ($result) {
      $result = mysqli_query($conn, $sqlCashier);
      if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        if ($user_data['password'] === $cashierPass) {
          $_SESSION['cashier_id'] = $cashierUser;
          header("Location: cashier.php");
        }
      }
    }
    echo '<script type="text/javascript">alert("Wrong Email or Password") </script>';
  }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $adminUser = $_POST['user'];
  $adminPass = $_POST['pass'];
  if (!empty($adminUser) && !empty($adminPass)) {
    $sqlAdmin = "SELECT * from admin WHERE user='$adminUser' AND password='$adminPass' ";
    $adminResult = mysqli_query($conn, $sqlAdmin);

    if ($adminResult) {
      $adminResult = mysqli_query($conn, $sqlAdmin);
      if ($adminResult && mysqli_num_rows($adminResult) > 0) {
        $user_data = mysqli_fetch_assoc($adminResult);
        if ($user_data['password'] === $adminPass) {
          $_SESSION['admin_id'] = $adminUser;
          header("Location: admin.php");
        }
      }
    }
    echo '<script type="text/javascript">alert("Wrong Email or Password") </script>';
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/pico-main/css/pico.min.css" />
  <link rel="stylesheet" href="css/index.css">
  <title>Queuing System</title>
</head>

<body>
  <div class="main">
    <h1 class="title">Admin Sign in</h1>
    <form action="" method="post" class="">
      <input type="text" name="user" placeholder="Username" />
      <input type="password" name="pass" placeholder="Password" />
      <button type="submit">Submit</button>
    </form>
  </div>
</body>

</html>