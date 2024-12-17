<?php
include('partials-frontend/menu.php'); // Database connection

if (isset($_GET['capacity'])) {
    $capacity = $_GET['capacity'];

    $sql = "SELECT table_name 
            FROM tbl_table 
            WHERE table_status = 'Free' AND table_capacity = $capacity";

    $res = mysqli_query($conn, $sql);

    $tables = [];
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $tables[] = $row;
        }
    }

    // Return tables as JSON
    echo json_encode($tables);
}
?>
