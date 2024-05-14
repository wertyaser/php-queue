<?php
session_start();
include ("db_connect.php");
// var_dump($_POST);
// Get all drivers name

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $transaction = $_POST["transaction"];
    $randomNumber = $_POST["random_number"];
    $customerName = $_POST["customer_name"];
    $projectSite = $_POST["project_site"];

    $sql = "INSERT INTO customers (name, type, queue_num, project_site) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);

    //queue for window 1
    if ($transaction === 'window1') {
        // $sql = "INSERT INTO customers (name, type, queue_num) VALUES (?,?,?)";
        // $stmt = $conn->prepare($sql);

        // Bind parameters with string data type
        $stmt->bind_param("ssis", $customerName, $transaction, $randomNumber, $projectSite);
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
        // $sql = "INSERT INTO customers (name, type, queue_num, project_site) VALUES (?,?,?,?)";
        // $stmt = $conn->prepare($sql);

        // Bind parameters with string data type
        $stmt->bind_param("ssis", $customerName, $transaction, $randomNumber, $projectSite);
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
        $sql_insert_queue = "INSERT INTO queue2 (customer_id, queue_number, status, type, site) VALUES (?, ?, 'queued', ?, ?)";
        $stmt_insert_queue = $conn->prepare($sql_insert_queue);
        $stmt_insert_queue->bind_param("iiss", $customer_id, $queue_number, $transaction, $projectSite);
        $stmt_insert_queue->execute();
        //new ^

        echo "Random number saved successfully!";
    }
    // elseif ($transaction === 'window3') {
    //     // Bind parameters with string data type
    //     $stmt->bind_param("ssi", $customerName, $transaction, $randomNumber);
    //     $stmt->execute();

    //     // Get the customer_id of the inserted customer
    //     $customer_id = $conn->insert_id;

    //     // Get the current maximum queue number and increment it
    //     $sql_max_queue_number = "SELECT MAX(queue_number) AS max_queue_number FROM queue3";
    //     $result_max_queue_number = $conn->query($sql_max_queue_number);
    //     $row_max_queue_number = $result_max_queue_number->fetch_assoc();
    //     $max_queue_number = $row_max_queue_number["max_queue_number"];
    //     $queue_number = $max_queue_number + 1;

    //     //new 
    //     $sql_insert_queue = "INSERT INTO queue3 (customer_id, queue_number, status, type) VALUES (?, ?, 'queued', ?)";
    //     $stmt_insert_queue = $conn->prepare($sql_insert_queue);
    //     $stmt_insert_queue->bind_param("iis", $customer_id, $queue_number, $transaction);
    //     $stmt_insert_queue->execute();
    //     //new ^

    //     echo "Random number saved successfully!";
    // } 
    else {
        // Handle invalid transaction value
        echo "Invalid transaction value.";
    }
    $stmt->close();
    $stmt_insert_queue->close(); //new
    // Do not close the connection here

}

//for mapping drivers/helpers names
$sql_names = "SELECT * FROM drivers_helpers";
$names_result = $conn->query($sql_names);

$sql_sites = "SELECT * FROM sites";
$sites_result = $conn->query($sql_sites);

$conn->close();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="stylesheet" href="./css/pico-main/css/pico.min.css" /> -->
    <link rel="stylesheet" href="css/output.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Queuing System</title>
</head>

<body class="bg-blue-500">
    <div class="flex justify-center items-center h-screen p-10">
        <div class="w-6/12 p-5 shadow-xl bg-white  rounded-md border">
            <!-- <h1 class="title">Queuing System</h1> -->
            <img class="mx-auto" src="assets/logo.png" alt="Buildnet Logo">
            <form class="" id="transactionForm">
                <select class="p-4 border block w-full mt-3" id="customer_name" name="customer_name">
                    <option value="" selected disabled>Select a name</option>
                    <?php
                    if ($names_result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $names_result->fetch_assoc()) {
                            echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </select>
                <select class="p-4 border block w-full mt-3" id="transaction" name="transaction" required
                    onchange="showSelection(this)">
                    <option value="" selected disabled>Select a Transaction</option>
                    <option value="window1">Dispatch</option>
                    <option value="window2">Loading & Unloading</option>
                </select>
                <select class="p-4 border block w-full mt-3" style="display: none;" name="project_site"
                    id="project_site">
                    <option value="" selected disabled>Select Project Site</option>
                    <?php
                    if ($sites_result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $sites_result->fetch_assoc()) {
                            echo "<option value='" . $row["site"] . "'>" . $row["site"] . "</option>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </select>
                <div class="">
                    <button class="col-span-2 w-full mt-3 p-3 bg-blue-500 text-white rounded-lg shadow-lg" type="button"
                        onclick="generateRandomNumber()">
                        Generate Queue Number
                    </button>
                </div>
            </form>

            <!-- <div class="grid grid-cols-3 mt-3 gap-2">
                    <button class=" p-3 bg-yellow-500 text-white rounded-lg shadow-lg" type="button"
                        onclick="handleClearFields()">Clear</button>
                </div> -->
        </div>
    </div>



</body>
<script>
    function showSelection(selectElement) {
        var additionalSelect = document.getElementById('project_site');

        if (selectElement.value === 'window2') {
            additionalSelect.style.display = 'block';
        } else {
            additionalSelect.style.display = 'none';

        }
    }

    function generateRandomNumber() {
        const transaction = document.getElementById('transaction').value;
        const customerName = document.getElementById('customer_name').value;
        const site = document.getElementById('project_site').value;
        const randomNumber = Math.floor(Math.random() * 9000) + 1000;

        // Save to database using AJAX
        $.ajax({
            type: 'POST',
            url: 'home.php',
            data: { transaction: transaction, random_number: randomNumber, customer_name: customerName, project_site: site },
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