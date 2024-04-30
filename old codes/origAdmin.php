<?php
session_start();
include ("db_connect.php");
include ("function.php");
check_login($conn);
$admin_data = check_login($conn);
$admin_type = $_SESSION['type'];

$button_name = 'next_customer';
if ($admin_type === 'window1') {
    $button_name .= '1';
} elseif ($admin_type === 'window2') {
    $button_name .= '2';
} elseif ($admin_type === 'window3') {
    $button_name .= '3';
}

if (isset($_POST["next_customer1"])) {
    // Update queue status for current and next customer

    // $sql_update_current = "UPDATE queue SET status='served' WHERE status='serving'";
    // $sql_update_next = "UPDATE queue SET status='serving' WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";
    $current_time = date('Y-m-d H:i:s');

    // Update queue status for current and next customer
    $sql_update_current = "UPDATE queue SET status='served', time_end='$current_time' WHERE status='serving'";
    $sql_update_next = "UPDATE queue SET status='serving', time_start='$current_time' WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";

    $conn->query($sql_update_current);
    $conn->query($sql_update_next);
}

if (isset($_POST["next_customer2"])) {
    // Update queue status for current and next customer
    $sql_update_current = "UPDATE queue2 SET status='served' WHERE status='serving'";
    $sql_update_next = "UPDATE queue2 SET status='serving' WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";
    $conn->query($sql_update_current);
    $conn->query($sql_update_next);
}
if (isset($_POST["next_customer3"])) {
    // Update queue status for current and next customer
    $sql_update_current = "UPDATE queue3 SET status='served' WHERE status='serving'";
    $sql_update_next = "UPDATE queue3 SET status='serving' WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";
    $conn->query($sql_update_current);
    $conn->query($sql_update_next);
}


$sql_count_transactions = "SELECT COUNT(*) AS total_transactions FROM customers WHERE type = '$admin_type' AND DATE(date) = CURDATE()";
$result_count_transactions = mysqli_query($conn, $sql_count_transactions);
$row_count_transactions = mysqli_fetch_assoc($result_count_transactions);
$total_transactions = $row_count_transactions['total_transactions'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/output.css" />
    <title>admin</title>
</head>

<body class="bg-blue-400 min-h-screen">
    <main class="mx-auto w-11/12 max-w-7xl h-full pb-16">

        <div class="flex justify-between pt-24 mb-10">
            <h1 class="text-white font-display text-5xl">Admin</h1>
            <div class="flex gap-3">
                <button class="p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md px-6"><a
                        href="monitor.php">Open Monitoring</a></button>
                <button class="p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md px-6"><a
                        href="home.php">Queue Generator</a></button>
                <button class="p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md px-6"><a
                        href="logout.php">Logout</a></button>
                <form action="" method="post">
                    <button name="<?php echo $button_name; ?>" class=" p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md
                            px-6">Next</button>
                </form>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <h1 class="text-xl text-blue-700 font-bold my-5 text-center">Total of Transactions(Today):
                <?php echo $total_transactions ?>
            </h1>
            <table class="w-full text-lg text-left rounded-full">
                <thead class="text-lg text-white uppercase bg-blue-600 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Queue Number
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Transaction Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Time Start
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Time End
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>

                <?php
                $sql = "SELECT * FROM `customers` WHERE type = '$admin_type'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $queue_num = $row['queue_num'];
                        $name = $row['name'];
                        $type = $row['type'];
                        $date = $row['date'];
                        $timeStart = $row['time_start'];
                        $timeEnd = $row['time_end'];
                        // $duration = $row['duration'];
                        echo '
                        <tbody>
                        <tr class="border-b font-light whitespace-nowrap text-white">
                        <td class="px-6 py-4">' . $id . '</td>
                        <td class="px-6 py-4">' . $queue_num . '</td>
                        <td class="px-6 py-4">' . $name . '</td>
                        <td class="px-6 py-4">' . $type . '</td>
                        <td class="px-6 py-4">' . $date . '</td>
                        <td class="px-6 py-4">' . $timeStart . '</td>
                        <td class="px-6 py-4">' . $timeEnd . '</td>
                      
                        <td class="px-6 py-4">
                        <a class="p-2 bg-green-600 text-semibold rounded-lg border shadow border-green-400" href="edit-customer.php?update_id=' . $id . '">Edit</a>
                                <a class="p-2 bg-red-600 text-semibold rounded-lg border border-red-400 shadow" href="delete.php?delete_id=' . $id . '">Delete</a>
                                </td>
                                </tr>
                                </tbody>
                                ';
                    }
                }
                ?>
            </table>
        </div>
    </main>
</body>

</html>

<!-- 
// // Get the current date
// $current_date = date("Y-m-d");

// // SQL query to count transactions by type for the current date
// $sql_count_by_type = "SELECT type, COUNT(*) AS count FROM `customers` WHERE date = '$current_date' GROUP BY type";
// $result_count_by_type = mysqli_query($conn, $sql_count_by_type);

// // Store the counts in an associative array
// $type_counts = array();
// while ($row_count_by_type = mysqli_fetch_assoc($result_count_by_type)) {
// $type_counts[$row_count_by_type['type']] = $row_count_by_type['count'];
// } -->