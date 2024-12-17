<?php 
    include('../config/constant.php');

    // Check if reservation_id is set and is a valid integer
    if (isset($_GET['reservation_id']) && is_numeric($_GET['reservation_id'])) {
        $reservation_id = intval($_GET['reservation_id']); // Convert to integer

        // SQL query to delete reservation
        $sql = "DELETE FROM tbl_reservation WHERE reservation_id = $reservation_id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $_SESSION['delete'] = "<div class='success'>Reservation Deleted Successfully</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Reservation. Try Again Later.</div>";
        }

        // Redirect to manage reservation page
        header('location:' . SITEURL . 'admin/manage-reservation.php');
    } else {
        // If reservation_id is not set or not valid, redirect to manage reservation page with an error
        $_SESSION['delete'] = "<div class='error'>Invalid Reservation ID.</div>";
        header('location:' . SITEURL . 'admin/manage-reservation.php');
    }
?>
