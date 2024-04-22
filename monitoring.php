<?php
include 'php/db_connect.php';

// Get current and next customer from the queue
$sql_current = "SELECT * FROM queue WHERE status='serving' LIMIT 1";
$sql_next = "SELECT * FROM queue WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";
$result_current = $conn->query($sql_current);
$result_next = $conn->query($sql_next);

// Fetch current customer's name
$current_customer_name = "No customer";
if ($result_current->num_rows > 0) {
  $current_customer = $result_current->fetch_assoc();
  $current_customer_id = $current_customer["customer_id"];
  $sql_current_customer_name = "SELECT name FROM customers WHERE id=$current_customer_id";
  $result_current_customer_name = $conn->query($sql_current_customer_name);
  if ($result_current_customer_name->num_rows > 0) {
    $current_customer_name = $result_current_customer_name->fetch_assoc()["name"];
  }
}

// Fetch next customer's name
$next_customer_name = "No customer";
if ($result_next->num_rows > 0) {
  $next_customer = $result_next->fetch_assoc();
  $next_customer_id = $next_customer["customer_id"];
  $sql_next_customer_name = "SELECT name FROM customers WHERE id=$next_customer_id";
  $result_next_customer_name = $conn->query($sql_next_customer_name);
  if ($result_next_customer_name->num_rows > 0) {
    $next_customer_name = $result_next_customer_name->fetch_assoc()["name"];
  }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/output.css" />
  <!-- <link rel="stylesheet" href="./css/pico-main/css/pico.min.css" /> -->
  <title>Queue Monitoring</title>
</head>

<body class="">
  <div class="text-center">
    <marquee behavior="" direction="left" width="100%">
      <h1 class="text-2xl">BUILDNET CONSTRUCTION INC.</h1>
    </marquee>
    <h1 class="text-3xl font-semibold my-5">MONITORING</h1>
  </div>
  <div class="grid grid-cols-3 gap-4 justify-center bg-blue-400 text-center">
    <div class="my-5">
      <h1 class="text-2xl text-white font-semibold">Window 1</h1>
      <p><?php echo $current_customer_name; ?></p>
    </div>
    <div class="my-5">
      <h1 class="text-2xl text-white font-semibold">Window 2</h1>
    </div>
    <div class="my-5">
      <h1 class="text-2xl text-white font-semibold">Window 3</h1>
    </div>
  </div>
  <div class="bg-yellow-400 py-5">
    <h2 class="">Next Customer: <?php echo $next_customer_name; ?></h2>
  </div>
</body>

<script>
  // Function to reload the page every 5 seconds
  function reloadPage() {
    setTimeout(function () {
      location.reload();
    }, 5000); // 3000 milliseconds = 5 seconds
  }

  // Call the reloadPage function when the page loads
  window.onload = function () {
    reloadPage();
  };
</script>

</html>