<?php
include ("db_connect.php"); // Include your database connection file
$window = "window2"; // Specify the window to display

// Fetch current customer's queue number
$sql_current = "SELECT customer_id FROM queue2 WHERE status='serving' AND type='$window' LIMIT 1";
$result_current = $conn->query($sql_current);
$current_customer_number = "No customer";
if ($result_current->num_rows > 0) {
    $current_customer_id = $result_current->fetch_assoc()["customer_id"];
    $sql_current_customer_number = "SELECT queue_num FROM customers WHERE id=$current_customer_id";
    $result_current_customer_number = $conn->query($sql_current_customer_number);
    if ($result_current_customer_number->num_rows > 0) {
        $current_customer_number = $result_current_customer_number->fetch_assoc()["queue_num"];
    }
}

$sql_queued = "SELECT customer_id FROM queue2 WHERE status='queued' AND type='$window' ORDER BY customer_id ASC";
$result_queued = $conn->query($sql_queued);
$queued_customers = [];
if ($result_queued->num_rows > 0) {
    while ($row = $result_queued->fetch_assoc()) {
        $customer_id = $row["customer_id"];
        $sql_customer_number = "SELECT queue_num FROM customers WHERE id=$customer_id";
        $result_customer_number = $conn->query($sql_customer_number);
        if ($result_customer_number->num_rows > 0) {
            $queued_customers[] = $result_customer_number->fetch_assoc()["queue_num"];
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <title>Monitoring Page</title>

</head>

<body class="bg-blue-400 ">
    <div class="my-5 bg-yellow-500 p-5 mx-10">
        <h1 class="text-center font-semibold text-white text-7xl">WINDOW 2</h1>
    </div>
    <div class="grid grid-rows-4 grid-flow-col gap-4 my-5 mx-10">
        <div class="row-span-4 col-span-2 bg-blue-500 p-5 rounded-lg">
            <h1 class="text-center text-white font-semibold text-6xl">NOW SERVING</h1>
            <hr class="my-5">
            <p class="text-center text-white text-semibold text-8xl my-5"><?php echo $current_customer_number; ?></p>
        </div>
        <div class="row-span-4 bg-blue-500 p-5 rounded-lg">
            <h1 class="text-center text-white font-semibold text-6xl">WAITING</h1>
            <hr class="my-5">
            <?php foreach ($queued_customers as $queued_customer) { ?>
                <p class="text-white text-4xl font-semibold text-center"><?php echo $queued_customer; ?></p>
            <?php } ?>
        </div>
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

<!-- 
// Fetch next customer's queue number
// $sql_next = "SELECT customer_id FROM queue WHERE status='queued' AND type='$window' ORDER BY customer_id ASC LIMIT 1";
// $result_next = $conn->query($sql_next);
// $next_customer_number = "No customer";
// if ($result_next->num_rows > 0) {
//     $next_customer_id = $result_next->fetch_assoc()["customer_id"];
//     $sql_next_customer_number = "SELECT queue_num FROM customers WHERE id=$next_customer_id";
//     $result_next_customer_number = $conn->query($sql_next_customer_number);
//     if ($result_next_customer_number->num_rows > 0) {
//         $next_customer_number = $result_next_customer_number->fetch_assoc()["queue_num"];
//     }
// } -->