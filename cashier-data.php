<?php
session_start();
include ("db_connect.php");
include ("function.php");
check_cashier($conn);
$cashier_data = check_cashier($conn);
$cashier_type = $_SESSION['type'];

$sql_count_transactions = "SELECT COUNT(*) AS total_transactions FROM customers WHERE type = '$cashier_type' AND DATE(date) = CURDATE()";
$result_count_transactions = mysqli_query($conn, $sql_count_transactions);
$row_count_transactions = mysqli_fetch_assoc($result_count_transactions);
$total_transactions = $row_count_transactions['total_transactions'];

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="cashier_report.xls"');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier</title>
</head>

<body>
    <main>

        <div>
            <h1>Cashier Report</h1>
        </div>
        <div>
            <h1>Total of Transactions(Today):
                <?php echo $total_transactions ?>
            </h1>
            <table>
                <thead>
                    <tr>

                        <th scope="col">
                            Queue Number
                        </th>
                        <th scope="col">
                            Name
                        </th>
                        <th scope="col">
                            Transaction Type
                        </th>
                        <th scope="col">
                            Date
                        </th>
                        <th scope="col">
                            Start
                        </th>
                        <th scope="col">
                            End
                        </th>
                        <th scope="col">
                            Remarks
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
            WHERE c.type = '$cashier_type'
            AND DATE(date) = CURDATE()";


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
                            } elseif ($row['q3_time_start'] !== null && $row['q3_time_end'] !== null) {
                                $time_start = $row['q3_time_start'];
                                $time_end = $row['q3_time_end'];
                            }

                            echo '
                   
        <tr>
            
            <td>' . $queue_num . '</td>
            <td>' . $name . '</td>
            <td>' . $type . '</td>
            <td>' . $date . '</td>
            <td>' . $time_start . '</td>
            <td>' . $time_end . '</td>
            <td>' . $site . '</td>
            <td>' . $remarks . '</td>
           
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