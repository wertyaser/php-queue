<?php
include ("db_connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerName = $_POST["customer_name"];

    $sql = "INSERT INTO drivers_helpers (name) VALUES (?)";
}

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
            <img class="mx-auto" src="assets/logo.png" alt="Buildnet Logo">
            <h1 class="text-xl font-light my-3">Register your name:</h1>
            <form class="" id="transactionForm">
                <input class="p-4 border block w-full mt-3" type="text" id="customer_name" name="customer_name"
                    placeholder="Name" required oninput="this.value = this.value.toUpperCase()">
                <div>
                    <button class="w-full mt-3 p-3 bg-blue-500 text-white rounded-lg shadow-lg" type="button">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>



</body>

</html>