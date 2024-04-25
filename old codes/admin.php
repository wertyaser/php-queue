<?php
session_start();
include 'php/db_connect.php';

// // Check if the user is logged in
// if (!isset($_SESSION['username'])) {
//     header('Location: index.php');
//     exit;
// }

// // Get the logged-in admin user's type
// $admin_type = $_SESSION['type'];

// Handle serving next customer
if (isset($_POST["next_customer"])) {
    // Update queue status for current and next customer
    $sql_update_current = "UPDATE queue SET status='served' WHERE status='serving'";
    $sql_update_next = "UPDATE queue SET status='serving' WHERE status='queued' ORDER BY customer_id ASC LIMIT 1";
    $conn->query($sql_update_current);
    $conn->query($sql_update_next);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/output.css" />
    <title>Document</title>
</head>

<body class="bg-blue-400 min-h-screen">
    <main class="mx-auto w-11/12 max-w-7xl h-full pb-16">
        <div class="flex justify-between pt-24 mb-10">
            <h1 class="text-white font-display text-5xl">Admin</h1>
            <div class="flex gap-3">
                <button class="p-3 bg-yellow-400 text-white rounded-md border border-white font-md shadow-md px-6"><a
                        href="monitoring.php">Open Monitoring</a></button>
                <form action="" method="post">
                    <button name="next_customer" class=" p-3 bg-yellow-400 text-white rounded-md border border-white font-md shadow-md
                        px-6">Next</button>
                </form>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg " data-aos="flip-up">
            <table class="w-full text-xl text-left ">
                <thead class="text-xl text-white uppercase bg-pink ">
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
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>

                <?php
                $sql = "SELECT * FROM `customers`";
                // $sql = "SELECT * FROM `queue` WHERE type = '$admin_type'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $queue_num = $row['queue_num'];
                        $name = $row['name'];
                        $type = $row['type'];
                        $date = $row['date'];
                        $duration = $row['duration'];
                        echo '
                        <tbody>
                            <tr class="border-b font-light whitespace-nowrap text-white">
                                <td class="px-6 py-4">' . $id . '</td>
                                <td class="px-6 py-4">' . $queue_num . '</td>
                                <td class="px-6 py-4">' . $name . '</td>
                                <td class="px-6 py-4">' . $type . '</td>
                                <td class="px-6 py-4">' . $date . '</td>
                                <td class="px-6 py-4">' . $duration . '</td>
                                <td class="px-6 py-4">
                                    <button class="p-3 rounded-lg border shadow-sm">Edit</button>
                                    <button class="p-3 rounded-lg border shadow-sm">Delete</button>
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