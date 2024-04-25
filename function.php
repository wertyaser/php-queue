<?php

function check_login($conn)
{
    if (isset($_SESSION['admin_id'])) {
        $id = $_SESSION['admin_id'];
        $query = "select * from admin where user = '$id' limit 1";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['type'] = $user_data['type'];
            return $user_data;
        }
    } else {
        header("Location: error-page.php");
    }
}