<?php
include ("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $customerName = $_POST["customer_name"];

    if (!empty($customerName)) {
        $query = "SELECT * FROM drivers_helpers WHERE name = '$customerName' limit 1";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            echo "Name already exists.";
        } else {
            $query = "INSERT INTO `drivers_helpers` (name) VALUES ('$customerName');";

            $result = mysqli_query($conn, $query);

            echo "<script>alert('Successfully Registered');</script>";
            // if ($result) {

            //     header("Location: register.php");
            //     die;
            // } else {
            //     echo "<script>alert(Error inserting data into the database.);</script>";
            // }
        }
    } else {
        echo "Please enter some valid information!";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/output.css">
    <title>Driver/Helper Registration</title>
</head>

<body class="bg-blue-500">
    <div class="flex justify-center items-center h-screen p-10">
        <div class="w-6/12 p-5 shadow-xl bg-white  rounded-md border">
            <a class="px-4 bg-[#151398] text-white py-2 rounded-md mt-3 border border-black" href="admin.php">Back</a>
            <img class="mx-auto" src="assets/logo.png" alt="Buildnet Logo">
            <h1 class="text-xl font-light my-3">Name:</h1>
            <form method="post">
                <input class="p-4 border block w-full mt-3" type="text" id="customer_name" name="customer_name"
                    placeholder="Name" required oninput="this.value = this.value.toUpperCase()">
                <button class="col-span-2 w-full mt-3 p-3 bg-blue-500 text-white rounded-lg shadow-lg" type="submit">
                    Submit
                </button>
            </form>
        </div>
    </div>
</body>

</html>