<?php 
include('../config/constant.php');

// Check if reservation_id is set and is a valid integer
if (isset($_GET['reservation_id']) && is_numeric($_GET['reservation_id'])) {
    $reservation_id = intval($_GET['reservation_id']); // Convert to integer

    // Step 1: Find the table associated with this reservation
    $sql_get_table = "SELECT table_name FROM tbl_reservation WHERE reservation_id = $reservation_id";
    $res_get_table = mysqli_query($conn, $sql_get_table);

    if ($res_get_table && mysqli_num_rows($res_get_table) == 1) {
        $row = mysqli_fetch_assoc($res_get_table);
        $table_name = $row['table_name']; // Retrieve the associated table name

        // Step 2: Delete the reservation
        $sql_delete_reservation = "DELETE FROM tbl_reservation WHERE reservation_id = $reservation_id";
        $res_delete_reservation = mysqli_query($conn, $sql_delete_reservation);

        if ($res_delete_reservation) {
            // Step 3: Update the table status to 'Free'
            $sql_update_table = "UPDATE tbl_table SET table_status = 'Free' WHERE table_name = '$table_name'";
            $res_update_table = mysqli_query($conn, $sql_update_table);

            if ($res_update_table) {
                $_SESSION['delete'] = "<div class='success'>Reservation Deleted and Table Status Updated Successfully</div>";
            } else {
                $_SESSION['delete'] = "<div class='error'>Reservation Deleted, but Failed to Update Table Status. Try Again Later.</div>";
            }
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Reservation. Try Again Later.</div>";
        }
    } else {
        $_SESSION['delete'] = "<div class='error'>Invalid Reservation ID or No Associated Table Found.</div>";
    }

    // Redirect to manage reservation page
    header('location:' . SITEURL . 'admin/manage-reservation.php');
} else {
    // If reservation_id is not set or not valid, redirect to manage reservation page with an error
    $_SESSION['delete'] = "<div class='error'>Invalid Reservation ID.</div>";
    header('location:' . SITEURL . 'admin/manage-reservation.php');
}
?>
