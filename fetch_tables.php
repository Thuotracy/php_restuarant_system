<?php
include('partials-frontend/menu.php');  // Ensure database connection

if (isset($_POST['table_capacity'])) {
    $capacity = intval($_POST['table_capacity']);

    $sql_table = "SELECT table_name FROM tbl_table WHERE table_status = 'Free' AND table_capacity = $capacity";
    $res_table = mysqli_query($conn, $sql_table);

    if ($res_table && mysqli_num_rows($res_table) > 0) {
        while ($row = mysqli_fetch_assoc($res_table)) {
            echo "<option value='{$row['table_name']}'>{$row['table_name']}</option>";
        }
    } else {
        echo "<option value='' disabled>No suitable tables available</option>";
    }
}
?>
