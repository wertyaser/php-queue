<?php
include 'db_connect.php';

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM customers WHERE id = $id;";


    $result = mysqli_multi_query($conn, $sql);
    if ($result) {

        header("Location: admin.php?success=User has been delete successfully");
        exit();
    } else {
        // header("Location: delete.php?error=Unknown error has occured");
        exit();
    }
}