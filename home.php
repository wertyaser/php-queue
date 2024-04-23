<?php
// dashboard.php
include ("php/db_connect.php");
session_start();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["generate_queue"])) {
    // $customer_name = $_POST["customer_name"];

    $type = $_POST["type"];
    $queue_num = $_POST["queue_number"];

    // Insert customer name into the customers table
    $sql_insert_customer = "INSERT INTO customers (type, queue_num) VALUES ('$type', '$queue_num')";
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
  <!-- <link rel="stylesheet" href="./css/output.css" /> -->
  <title>Queuing System</title>
</head>

<body>
  <nav>
    <ul>
      <li><strong>Buildnet</strong></li>
    </ul>
    <ul>
      <li><a href="home.php" class="contrast">Home</a></li>
      <li><a href="admin.php" class="contrast">Admin</a></li>
      <li><a href="logout.php" class="contrast">Logout</a></li>
    </ul>
  </nav>


  <div class="main-home">
    <h1 class="title">Queuing System</h1>
    <form method="POST" action="home.php">
      <!-- <input type="text" id="customer_name" name="customer_name" placeholder="Name" required /> -->
      <input type="text" id="queueNumberInput" name="queue_number" disabled>
      <select name="type" required>
        <option selected disabled value="">
          Select your transaction type....
        </option>
        <option>Window 1</option>
        <option>Window 2</option>
        <option>Window 3</option>
        <option>Window 4</option>
      </select>
      <button type="submit" name="generate_queue" id="generateQueueBtn">
        Generate Queue Number
      </button>
      <!-- <button type="submit" name="next_customer">Next Customer</button> -->
    </form>
  </div>


  <!-- asdasdasd -->

</body>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("generateQueueBtn").addEventListener("click", function () {
      var selectedType = document.querySelector("select[name='type']").value;
      if (selectedType === "") {
        alert("Please select a transaction type.");
        return;
      }

      // Generate random number (e.g., between 1000 and 9999)
      var queueNumber = Math.floor(Math.random() * 9000) + 1000;

      // Set the generated queue number in the disabled input field
      document.getElementById("queueNumberInput").value = queueNumber;

      // Enable the input field before submitting the form
      document.getElementById("queueNumberInput").disabled = false;

    });
  });



</script>


</html>