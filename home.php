<?php
session_start();
include ("db_connect.php");
// var_dump($_POST);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $transaction = $_POST["transaction"];
    $randomNumber = $_POST["random_number"];

    $sql = "INSERT INTO customers (type, queue_num) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    if ($transaction === 'window1' || $transaction === 'window2' || $transaction === 'window3') {
        // Bind parameters with string data type
        $stmt->bind_param("si", $transaction, $randomNumber);
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
        $sql_insert_queue = "INSERT INTO queue (customer_id, queue_number, status) VALUES ($customer_id, $queue_number, 'queued')";
        $conn->query($sql_insert_queue);

        echo "Random number saved successfully!";
    } else {
        // Handle invalid transaction value
        echo "Invalid transaction value.";
    }

    $stmt->close();
    // Do not close the connection here
} else {
    // If the request is not a POST request, send an error response (optional)
    http_response_code(405);
    // echo "Method Not Allowed";
}

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
            <select id="transaction" name="transaction" required>
                <option value="window1">Transaction 1</option>
                <option value="window2">Transaction 2</option>
                <option value="window3">Transaction 3</option>
            </select>
            <button type="button" onclick="generateRandomNumber()">
                Generate Queue Number
            </button>
        </form>
    </div>




</body>
<script>
    function generateRandomNumber() {
        const transaction = document.getElementById('transaction').value;
        const randomNumber = Math.floor(Math.random() * 1000) + 1;

        // Save to database using AJAX
        $.ajax({
            type: 'POST',
            url: 'home.php',
            data: { transaction: transaction, random_number: randomNumber },
            success: function (response) {
                // Show SweetAlert
                swal({
                    title: 'Random Number Generated',
                    text: 'Transaction: ' + transaction + '\nQueue Number: ' + randomNumber,
                    icon: 'success',
                    button: 'OK'
                });
            }
        });
    }


</script>


</html>