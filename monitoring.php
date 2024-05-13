<?php
include ("db_connect.php"); // Include your database connection file
$window = "window1"; // Specify the window to display

// Fetch current customer's queue number
$sql_current1 = "SELECT customer_id FROM queue WHERE status='serving' AND type='$window' LIMIT 1";
$result_current1 = $conn->query($sql_current1);
$current_customer_number1 = "No customer";
if ($result_current1->num_rows > 0) {
    $current_customer_id = $result_current1->fetch_assoc()["customer_id"];
    $sql_current_customer_number = "SELECT queue_num FROM customers WHERE id=$current_customer_id";
    $result_current_customer_number = $conn->query($sql_current_customer_number);
    if ($result_current_customer_number->num_rows > 0) {
        $current_customer_number1 = $result_current_customer_number->fetch_assoc()["queue_num"];
    }
}

$sql_queued1 = "SELECT customer_id FROM queue WHERE status='queued' AND type='$window' ORDER BY customer_id ASC LIMIT 9";
$result_queued1 = $conn->query($sql_queued1);
$queued_customers1 = [];
if ($result_queued1->num_rows > 0) {
    while ($row = $result_queued1->fetch_assoc()) {
        $customer_id = $row["customer_id"];
        $sql_customer_number = "SELECT queue_num FROM customers WHERE id=$customer_id";
        $result_customer_number = $conn->query($sql_customer_number);
        if ($result_customer_number->num_rows > 0) {
            $queued_customers1[] = $result_customer_number->fetch_assoc()["queue_num"];
        }
    }
}

$window = "window2"; // Specify the window to display

// Fetch current customer's queue number
$sql_current2 = "SELECT customer_id FROM queue2 WHERE status='serving' AND type='$window' LIMIT 1";
$result_current2 = $conn->query($sql_current2);
$current_customer_number2 = "No customer";
if ($result_current2->num_rows > 0) {
    $current_customer_id = $result_current2->fetch_assoc()["customer_id"];
    $sql_current_customer_number = "SELECT queue_num FROM customers WHERE id=$current_customer_id";
    $result_current_customer_number = $conn->query($sql_current_customer_number);
    if ($result_current_customer_number->num_rows > 0) {
        $current_customer_number2 = $result_current_customer_number->fetch_assoc()["queue_num"];
    }
}

$sql_queued2 = "SELECT customer_id FROM queue2 WHERE status='queued' AND type='$window' ORDER BY customer_id ASC LIMIT 9";
$result_queued2 = $conn->query($sql_queued2);
$queued_customers2 = [];
if ($result_queued2->num_rows > 0) {
    while ($row = $result_queued2->fetch_assoc()) {
        $customer_id = $row["customer_id"];
        $sql_customer_number = "SELECT queue_num FROM customers WHERE id=$customer_id";
        $result_customer_number = $conn->query($sql_customer_number);
        if ($result_customer_number->num_rows > 0) {
            $queued_customers2[] = $result_customer_number->fetch_assoc()["queue_num"];
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
    <title>Monitoring</title>

</head>

<body class="bg-blue-400 h-screen mx-20">
    <div class="flex justify-between ">
        <img class=" my-5" src="assets/logo.png" alt="">
        <h1 class=" text-center shadow-sm my-auto text-8xl text-white font-semibold" id="current-time"></h1>
    </div>
    <main class="grid grid-rows-1 mx-auto">
        <div class="1">
            <div class="my-5 bg-yellow-500 p-5">
                <h1 class="text-center font-semibold text-white text-7xl">WINDOW 1 (DISPATCH)</h1>
            </div>
            <div class="grid grid-rows-4 grid-flow-col gap-4 my-5">
                <div class="row-span-4 col-span-2 bg-blue-500 p-5 rounded-lg">
                    <h1 class="text-center text-white font-semibold text-6xl">NOW SERVING</h1>
                    <hr class="my-5">
                    <p class="text-center text-white text-semibold text-9xl my-5">
                        <?php echo $current_customer_number1; ?>
                    </p>
                </div>
                <div class="row-span-4 bg-blue-500 p-5 rounded-lg">
                    <h1 class="text-center text-white font-semibold text-6xl">WAITING</h1>
                    <hr class="my-5">
                    <ol class="grid grid-cols-3">
                        <?php foreach ($queued_customers1 as $queued_customer) { ?>
                            <li class="text-white text-4xl font-semibold text-center"><?php echo $queued_customer; ?></li>
                        <?php } ?>
                    </ol>
                </div>
            </div>
        </div>


        <div class="2">
            <div class="my-5 bg-yellow-500 p-5">
                <h1 class="text-center font-semibold text-white text-7xl">WINDOW 2 (LOADING & UNLOADING)</h1>
            </div>
            <div class="grid grid-rows-4 grid-flow-col gap-4 my-5">
                <div class="row-span-4 col-span-2 bg-blue-500 p-5 rounded-lg">
                    <h1 class="text-center text-white font-semibold text-6xl">NOW SERVING</h1>
                    <hr class="my-5">
                    <p class="text-center text-white text-semibold text-9xl my-5">
                        <?php echo $current_customer_number2; ?>
                    </p>
                </div>
                <div class="row-span-4 bg-blue-500 p-5 rounded-lg">
                    <h1 class="text-center text-white font-semibold text-6xl">WAITING</h1>
                    <hr class="my-5">
                    <ol class="grid grid-cols-3">
                        <?php foreach ($queued_customers2 as $queued_customer) { ?>
                            <li class="text-white text-4xl font-semibold text-center"><?php echo $queued_customer; ?></li>
                        <?php } ?>
                    </ol>
                </div>
            </div>
        </div>
    </main>

</body>
<script>
    // Function to reload the page every 5 seconds
    function reloadPage() {
        setTimeout(function () {
            location.reload();
        }, 4000); // 3000 milliseconds = 5 seconds
    }

    // Call the reloadPage function when the page loads
    window.onload = function () {
        reloadPage();
    };

    // Function to display the current time
    let currentTime = document.getElementById("current-time");

    setInterval(() => {
        let date = new Date();
        currentTime.innerHTML = date.toLocaleTimeString();
    }, 1000);
    let date = new Date();
    time.innerHTML = date.toLocaleTimeString();

</script>

</html>