<?php include('partials-frontend/menu.php'); ?>

<?php
if (isset($_POST['submit'])) {
    // Retrieve form data
    $full_name = $_POST['full_name'];
    $id_no = $_POST['id_no'];
    $contact = $_POST['contact'];
    $table_capacity = $_POST['table_capacity'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $table_name = $_POST['table_name']; // New field for table name

    // Insert the data into the tbl_reservation table
    $sql = "INSERT INTO tbl_reservation (full_name, id_no, contact, table_capacity, reservation_date, reservation_time, table_name) 
            VALUES ('$full_name', '$id_no', '$contact', '$table_capacity', '$reservation_date', '$reservation_time', '$table_name')";

    $res = mysqli_query($conn, $sql);

    // Check if the reservation query executed successfully
    if ($res) {
        // Update the table status to 'Reserved'
        $update_table_sql = "UPDATE tbl_table SET table_status = 'Reserved' WHERE table_name = '$table_name'";
        $update_res = mysqli_query($conn, $update_table_sql);

        if ($update_res) {
            // Display success message
            $_SESSION['reservation'] = "<div class='success text-center'>Reservation made successfully!</div>";
            header('location:'.SITEURL); // Redirect to homepage or another page
        } else {
            // Display error message
            $_SESSION['reservation'] = "<div class='error text-center'>Failed to update table status. Try again later.</div>";
            header('location:'.SITEURL.'reservation.php'); // Redirect to the same page
        }
    } else {
        // Display error message
        $_SESSION['reservation'] = "<div class='error text-center'>Failed to make reservation. Try again later.</div>";
        header('location:'.SITEURL.'reservation.php'); // Redirect to the same page
    }
}
?>

<!-- Reservation Form Section Starts Here -->
<section class="food-search2">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your Reservation.</h2>

        <form action="" method="POST" class="order">
            <fieldset style="color: white;">
                <legend>Reservation Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full_name" placeholder="Tracy Wangari" class="input-responsive" required>

                <div class="order-label">ID Number</div>
                <input type="number" name="id_no" placeholder="12345678" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="number" name="contact" placeholder="0700000000" class="input-responsive" required>

                <div class="order-label">Number of People</div>
                <input type="number" name="table_capacity" placeholder="4 People" class="input-responsive" required>

                <div class="order-label">Table Name</div>
                <select name="table_name" class="input-responsive" required>
                    <option value="" disabled selected>Select a Free Table</option>
                    <?php
                    // Fetch tables with status 'Free' and matching table_capacity
                    $sql_table = "SELECT table_name FROM tbl_table WHERE table_status = 'Free'";
                    $res_table = mysqli_query($conn, $sql_table);

                    if ($res_table && mysqli_num_rows($res_table) > 0) {
                        while ($row = mysqli_fetch_assoc($res_table)) {
                            echo "<option value='{$row['table_name']}'>{$row['table_name']}</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No Free Tables Available</option>";
                    }
                    ?>
                </select>

                <div class="order-label">Date</div>
                <input type="date" name="reservation_date" class="input-responsive" required>

                <div class="order-label">Time</div>
                <input type="time" name="reservation_time" class="input-responsive" required>

                <input type="submit" name="submit" value="Make Reservation" class="btn">
            </fieldset>
        </form>
    </div>
</section>
<!-- Reservation Form Section Ends Here -->

<?php include('partials-frontend/footer.php'); ?>
