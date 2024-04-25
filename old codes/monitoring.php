<?php
include 'db_connect.php';

// Get current and next customer from the queue
$sql_current = "SELECT * FROM queue WHERE status='serving' LIMIT 1";
$sql_next = "SELECT * FROM queue WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";
$result_current = $conn->query($sql_current);
$result_next = $conn->query($sql_next);

// Fetch current customer's name
$current_customer_number = "No customer";
if ($result_current->num_rows > 0) {
  $current_customer = $result_current->fetch_assoc();
  $current_customer_id = $current_customer["customer_id"];
  $sql_current_customer_number = "SELECT queue_num FROM customers WHERE id=$current_customer_id";
  $result_current_customer_number = $conn->query($sql_current_customer_number);
  if ($result_current_customer_number->num_rows > 0) {
    $current_customer_number = $result_current_customer_number->fetch_assoc()["queue_num"];
  }
}

// Fetch next customer's name
$next_customer_number = "No customer";
if ($result_next->num_rows > 0) {
  $next_customer = $result_next->fetch_assoc();
  $next_customer_id = $next_customer["customer_id"];
  $sql_next_customer_number = "SELECT queue_num FROM customers WHERE id=$next_customer_id";
  $result_next_customer_number = $conn->query($sql_next_customer_number);
  if ($result_next_customer_number->num_rows > 0) {
    $next_customer_number = $result_next_customer_number->fetch_assoc()["queue_num"];
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

<body class="bg-blue-300">
  <div class="text-center">
    <marquee scrollamount="20" direction="left" width="80%">
      <h1 class="text-2xl text-white">BUILDNET CONSTRUCTION INC. BUILDNET CONSTRUCTION INC. BUILDNET CONSTRUCTION INC.
      </h1>
    </marquee>
    <h1 class="text-5xl font-bold my-5 text-white">MONITORING</h1>
  </div>
  <div class="grid grid-cols-3 gap-4 justify-center text-center rounded-t-lg shadow ">
    <div class="bg-blue-400 p-5 rounded-lg my-5">
      <h1 class="text-2xl text-white font-semibold mb-5">Window 1</h1>
      <hr>
      <p class="text-white font-mono font-bold my-16 text-6xl">W1-<?php echo $current_customer_number; ?></p>
    </div>
    <div class="bg-blue-400 p-5 rounded-lg min-h-52 my-5">
      <h1 class="text-2xl text-white font-semibold mb-5">Window 2</h1>
      <hr>
      <p class="text-white font-mono font-bold my-16 text-6xl">W2-<?php echo $current_customer_number; ?></p>
    </div>
    <div class="bg-blue-400 p-5 rounded-lg min-h-52 my-5">
      <h1 class="text-2xl text-white font-semibold mb-5">Window 3</h1>
      <hr>
      <p class="text-white font-mono font-bold my-16 text-6xl">W3-<?php echo $current_customer_number; ?></p>
    </div>
  </div>
  <div class="bg-yellow-400 py-5 rounded-b-lg shadow ">
    <h2 class="text-white font-bold ml-5">Next Customer: <?php echo $next_customer_number; ?></h2>
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