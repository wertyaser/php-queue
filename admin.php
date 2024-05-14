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
}
// } elseif ($admin_type === 'window3') {
//     $button_name .= '3';
// }

if (isset($_POST['next_customer1'])) {
    // Update queue status for current and next customer
    $sql_update_current_queue = "UPDATE queue SET status='served', time_end=NOW() WHERE status='serving'";
    $sql_update_next_queue = "UPDATE queue SET status='serving', time_start=NOW() WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";

    $conn->query($sql_update_current_queue);
    $conn->query($sql_update_next_queue);
}

if (isset($_POST["next_customer2"])) {
    // Update queue status for current and next customer
    $sql_update_current_queue = "UPDATE queue2 SET status='served', time_end=NOW() WHERE status='serving'";
    $sql_update_next_queue = "UPDATE queue2 SET status='serving', time_start=NOW() WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";

    $conn->query($sql_update_current_queue);
    $conn->query($sql_update_next_queue);
}
// if (isset($_POST["next_customer3"])) {
//     // Update queue status for current and next customer
//     $sql_update_current_queue = "UPDATE queue3 SET status='served', time_end=NOW() WHERE status='serving'";
//     $sql_update_next_queue = "UPDATE queue3 SET status='serving', time_start=NOW() WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";

//     $conn->query($sql_update_current_queue);
//     $conn->query($sql_update_next_queue);
// }


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
    <title>Admin Dashboard</title>
</head>

<body class="bg-blue-400 min-h-screen">
    <main class="mx-auto w-11/12 max-w-7xl h-full pb-16">
        <img class="mx-auto my-10" src="assets/logo.png" alt="">
        <div class="flex justify-between mb-10">
            <h1 class="text-white font-display text-5xl">Admin Dashboard</h1>
            <div class="flex gap-3">
                <a class="p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md px-6"
                    href="admin-data.php">Export to Excel</a>
                <a class="p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md px-6"
                    href="monitoring.php" target="_blank">Open Monitoring</a>
                <a class="p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md px-6"
                    href="home.php" target="_blank">Queue Generator</a>
                <form action="" method="post">
                    <button name="<?php echo $button_name; ?>" class=" p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md
                        px-6">Next</button>
                </form>
                <button class="p-3 bg-blue-600 text-white rounded-md border border-white font-md shadow-md px-6"><a
                        href="logout.php">Logout</a></button>
            </div>
        </div>
        <div class="flex gap-2 mx-auto w-full ">
            <a class="bg-yellow-500 border border-white p-3 rounded-lg text-white font-semibold font-italic text-center mt-3"
                href="register.php">Add Driver/Helper</a>
            <a class="bg-yellow-500 border border-white p-3 rounded-lg text-white font-semibold font-italic text-center mt-3"
                href="add-site.php">Add Site</a>
        </div>
        <div class="relative overflow-y-auto shadow-md sm:rounded-lg">
            <h1 class="text-xl text-blue-700 font-bold my-5 text-center">Total of Transactions(Today):
                <?php echo $total_transactions ?>
            </h1>
            <table class="w-full text-lg text-left rounded-full">
                <thead class="text-lg text-white uppercase bg-blue-600 ">
                    <tr>

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
                            Start
                        </th>
                        <th scope="col" class="px-6 py-3">
                            End
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Site
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Remarks
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT c.*, 
               q.time_start AS q_time_start, q.time_end AS q_time_end,
               q2.time_start AS q2_time_start, q2.time_end AS q2_time_end
            --    q3.time_start AS q3_time_start, q3.time_end AS q3_time_end
        FROM `customers` c
        LEFT JOIN `queue` q ON c.id = q.customer_id
        LEFT JOIN `queue2` q2 ON c.id = q2.customer_id
        -- LEFT JOIN `queue3` q3 ON c.id = q3.customer_id
        WHERE c.type = '$admin_type'
        AND DATE(c.date) = CURDATE()";

                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $queue_num = $row['queue_num'];
                            $name = $row['name'];
                            $type = $row['type'];
                            $date = $row['date'];
                            $remarks = $row['remarks'];
                            $site = $row['project_site'];
                            $time_start = '';
                            $time_end = '';

                            // Check which queue table contains valid data
                            if ($row['q_time_start'] !== null && $row['q_time_end'] !== null) {
                                $time_start = $row['q_time_start'];
                                $time_end = $row['q_time_end'];
                            } elseif ($row['q2_time_start'] !== null && $row['q2_time_end'] !== null) {
                                $time_start = $row['q2_time_start'];
                                $time_end = $row['q2_time_end'];
                            }
                            // elseif ($row['q3_time_start'] !== null && $row['q3_time_end'] !== null) {
                            //     $time_start = $row['q3_time_start'];
                            //     $time_end = $row['q3_time_end'];
                            // }
                    
                            echo '
                   
        <tr class="border-b font-light whitespace-nowrap text-white">
            
            <td class="px-6 py-4">' . $queue_num . '</td>
            <td class="px-6 py-4">' . $name . '</td>
            <td class="px-6 py-4">' . $type . '</td>
            <td class="px-6 py-4">' . $date . '</td>
            <td class="px-6 py-4">' . $time_start . '</td>
            <td class="px-6 py-4">' . $time_end . '</td>
            <td class="px-6 py-4">' . $site . '</td>
            <td class="px-6 py-4">' . $remarks . '</td>
            <td class="px-6 py-4">
                <a class="p-2 bg-green-600 text-semibold rounded-lg border shadow border-green-400" href="edit-admin.php?update_id=' . $id . '">Edit</a>
                <a class="p-2 bg-red-600 text-semibold rounded-lg border border-red-400 shadow" href="delete.php?delete_id=' . $id . '">Delete</a>
                </td>
        </tr>';
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </main>
</body>


</html>