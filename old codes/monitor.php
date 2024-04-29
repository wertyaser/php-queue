<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Page</title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            /* Changed to 1 column */
            gap: 10px;
        }

        .grid-item {
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
</head>

<body>
    <h1>Monitoring Page</h1>
    <div class="grid-container">
        <?php
        include ("db_connect.php"); // Include your database connection file
        $window = "window1"; // Specify the window to display
        
        echo '<div class="grid-item">';
        echo '<h2>' . ucfirst($window) . '</h2>'; // Display window name
        
        // Fetch current customer's queue number
        $sql_current = "SELECT customer_id FROM queue WHERE status='serving' AND type='$window' LIMIT 1";
        $result_current = $conn->query($sql_current);
        $current_customer_number = "No customer";
        if ($result_current->num_rows > 0) {
            $current_customer_id = $result_current->fetch_assoc()["customer_id"];
            $sql_current_customer_number = "SELECT queue_num FROM customers WHERE id=$current_customer_id";
            $result_current_customer_number = $conn->query($sql_current_customer_number);
            if ($result_current_customer_number->num_rows > 0) {
                $current_customer_number = $result_current_customer_number->fetch_assoc()["queue_num"];
            }
        }

        echo '<p>Current Customer: ' . $current_customer_number . '</p>';

        // Fetch next customer's queue number
        $sql_next = "SELECT customer_id FROM queue WHERE status='queued' AND type='$window' ORDER BY customer_id ASC LIMIT 1";
        $result_next = $conn->query($sql_next);
        $next_customer_number = "No customer";
        if ($result_next->num_rows > 0) {
            $next_customer_id = $result_next->fetch_assoc()["customer_id"];
            $sql_next_customer_number = "SELECT queue_num FROM customers WHERE id=$next_customer_id";
            $result_next_customer_number = $conn->query($sql_next_customer_number);
            if ($result_next_customer_number->num_rows > 0) {
                $next_customer_number = $result_next_customer_number->fetch_assoc()["queue_num"];
            }
        }

        echo '<p>Next Customer: ' . $next_customer_number . '</p>';

        echo '</div>';
        ?>
    </div>
</body>

</html>