<?php
include ("php/db_connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check username and password against the database
  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM admin WHERE user='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    // $_SESSION["username"] = $username;
    // header("Location: home.php");
    $row = $result->fetch_assoc();
    $_SESSION["username"] = $username;
    $_SESSION["admin_id"] = $row["id"];
    $_SESSION["type"] = $row["type"];
    header("Location: home.php");
    exit();
  } else {
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
      <input type="text" name="username" aria-label="Text" placeholder="Enter your username" />
      <input type="password" name="password" placeholder="Enter your password" />
      <button type="submit">Submit</button>
    </form>
  </div>
</body>

</html>