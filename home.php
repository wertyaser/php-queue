<?php
session_start();
include ("db_connect.php");
// var_dump($_POST);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $transaction = $_POST["transaction"];
    $randomNumber = $_POST["random_number"];
    $customerName = $_POST["customer_name"];

    $sql = "INSERT INTO customers (name, type, queue_num) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);

    //queue for window 1
    if ($transaction === 'window1') {
        // Bind parameters with string data type
        $stmt->bind_param("ssi", $customerName, $transaction, $randomNumber);
        $stmt->execute();

        // Get the customer_id of the inserted customer
        $customer_id = $conn->insert_id;

        // Get the current maximum queue number and increment it
        $sql_max_queue_number = "SELECT MAX(queue_number) AS max_queue_number FROM queue";
        $result_max_queue_number = $conn->query($sql_max_queue_number);
        $row_max_queue_number = $result_max_queue_number->fetch_assoc();
        $max_queue_number = $row_max_queue_number["max_queue_number"];
        $queue_number = $max_queue_number + 1;

        // Add customer to queue table
        // $sql_insert_queue = "INSERT INTO queue (customer_id, queue_number, status, type) VALUES ($customer_id, $queue_number, 'queued')";
        // $conn->query($sql_insert_queue);

        //new 
        $sql_insert_queue = "INSERT INTO queue (customer_id, queue_number, status, type) VALUES (?, ?, 'queued', ?)";
        $stmt_insert_queue = $conn->prepare($sql_insert_queue);
        $stmt_insert_queue->bind_param("iis", $customer_id, $queue_number, $transaction);
        $stmt_insert_queue->execute();
        //new ^

        echo "Random number saved successfully!";

        //for windows 2
    } elseif ($transaction === 'window2') {
        // Bind parameters with string data type
        $stmt->bind_param("ssi", $customerName, $transaction, $randomNumber);
        $stmt->execute();

        // Get the customer_id of the inserted customer
        $customer_id = $conn->insert_id;

        // Get the current maximum queue number and increment it
        $sql_max_queue_number = "SELECT MAX(queue_number) AS max_queue_number FROM queue2";
        $result_max_queue_number = $conn->query($sql_max_queue_number);
        $row_max_queue_number = $result_max_queue_number->fetch_assoc();
        $max_queue_number = $row_max_queue_number["max_queue_number"];
        $queue_number = $max_queue_number + 1;

        //new 
        $sql_insert_queue = "INSERT INTO queue2 (customer_id, queue_number, status, type) VALUES (?, ?, 'queued', ?)";
        $stmt_insert_queue = $conn->prepare($sql_insert_queue);
        $stmt_insert_queue->bind_param("iis", $customer_id, $queue_number, $transaction);
        $stmt_insert_queue->execute();
        //new ^

        echo "Random number saved successfully!";
    } elseif ($transaction === 'window3') {
        // Bind parameters with string data type
        $stmt->bind_param("ssi", $customerName, $transaction, $randomNumber);
        $stmt->execute();

        // Get the customer_id of the inserted customer
        $customer_id = $conn->insert_id;

        // Get the current maximum queue number and increment it
        $sql_max_queue_number = "SELECT MAX(queue_number) AS max_queue_number FROM queue3";
        $result_max_queue_number = $conn->query($sql_max_queue_number);
        $row_max_queue_number = $result_max_queue_number->fetch_assoc();
        $max_queue_number = $row_max_queue_number["max_queue_number"];
        $queue_number = $max_queue_number + 1;

        //new 
        $sql_insert_queue = "INSERT INTO queue3 (customer_id, queue_number, status, type) VALUES (?, ?, 'queued', ?)";
        $stmt_insert_queue = $conn->prepare($sql_insert_queue);
        $stmt_insert_queue->bind_param("iis", $customer_id, $queue_number, $transaction);
        $stmt_insert_queue->execute();
        //new ^

        echo "Random number saved successfully!";
    } else {
        // Handle invalid transaction value
        echo "Invalid transaction value.";
    }
    $stmt->close();
    $stmt_insert_queue->close(); //new
    // Do not close the connection here

}

//for windows3


$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/pico-main/css/pico.min.css" />
    <link rel="stylesheet" href="css/index.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Queuing System</title>
</head>

<body>
    <div class="main-home">
        <h1 class="title">Queuing System</h1>
        <form id="transactionForm">
            <input type="text" id="customer_name" name="customer_name" placeholder="Name" required>
            <select id="transaction" name="transaction" required>
                <option value="window1">Dispatch</option>
                <option value="window2">Loading & Unloading</option>
            </select>
            <div class="">
                <button type="button" onclick="generateRandomNumber()">
                    Generate Queue Number
                </button>
                <button class="primary" onclick="handleClearFields()">Clear</button>
            </div>
        </form>
    </div>




</body>
<script>
    function handleClearFields() {
        const inputs = document.querySelectorAll("input");
        inputs.forEach((input) => (input.value = ""));
    }
    function generateRandomNumber() {
        const transaction = document.getElementById('transaction').value;
        const customerName = document.getElementById('customer_name').value;
        const randomNumber = Math.floor(Math.random() * 9000) + 1000;

        // Save to database using AJAX
        $.ajax({
            type: 'POST',
            url: 'home.php',
            data: { transaction: transaction, random_number: randomNumber, customer_name: customerName },
            success: function (response) {
                // Show SweetAlert
                swal({
                    title: 'Your Queue Number: ' + randomNumber,
                    text: 'Please proceed to the ' + transaction,
                    icon: 'success',
                    button: 'OK'
                });
            }
        });
    }


</script>


</html>