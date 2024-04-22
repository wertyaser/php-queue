<?php
// dashboard.php
include ("php/db_connect.php");
session_start();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["generate_queue"])) {
    $customer_name = $_POST["customer_name"];
    $type = $_POST["type"];

    // Insert customer name into the customers table
    $sql_insert_customer = "INSERT INTO customers (name, type) VALUES ('$customer_name', '$type')";
    $conn->query($sql_insert_customer);

    // Get the customer_id of the inserted customer
    $customer_id = $conn->insert_id;

    // Get the current maximum queue number and increment it
    $sql_max_queue_number = "SELECT MAX(queue_number) AS max_queue_number FROM queue";
    $result_max_queue_number = $conn->query($sql_max_queue_number);
    $row_max_queue_number = $result_max_queue_number->fetch_assoc();
    $max_queue_number = $row_max_queue_number["max_queue_number"];
    $queue_number = $max_queue_number + 1;

    // Add customer to queue table
    $sql_insert_queue = "INSERT INTO queue (customer_id, queue_number, status) VALUES ($customer_id, $queue_number, 'queued')";
    $conn->query($sql_insert_queue);
  }


  // Handle serving next customer
  if (isset($_POST["next_customer"])) {
    // Update queue status for current and next customer
    $sql_update_current = "UPDATE queue SET status='served' WHERE status='serving'";
    $sql_update_next = "UPDATE queue SET status='serving' WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";
    $conn->query($sql_update_current);
    $conn->query($sql_update_next);
  }
}

// Close the database connection
$conn->close();
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
  <nav>
    <ul>
      <li><strong>Buildnet</strong></li>
    </ul>
    <ul>
      <li><a href="home.php" class="contrast">Home</a></li>
      <li><a href="monitoring.php" class="contrast">Monitoring</a></li>
      <li><a href="controller.php" class="contrast">Controller</a></li>
      <li><a href="admin.php" class="contrast">Admin</a></li>
      <li><a href="php/logout.php" class="contrast">Logout</a></li>
    </ul>
  </nav>


  <div class="main-home">
    <h1 class="title">Queuing System</h1>
    <form method="POST" action="home.php">
      <input type="text" id="customer_name" name="customer_name" placeholder="Name" />
      <select name="type">
        <option selected disabled value="">
          Select your transaction type....
        </option>
        <option>Window 1</option>
        <option>Window 2</option>
        <option>Window 3</option>
        <option>Window 4</option>
      </select>
      <button type="submit" name="generate_queue">
        Generate Queue Number
      </button>
      <button type="submit" name="next_customer">Next Customer</button>
    </form>
  </div>


  <!-- asdasdasd -->

</body>
<script src="js/minimal-theme-switcher.js"></script>

</html>