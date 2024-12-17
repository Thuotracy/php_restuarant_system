<?php include('partials/menu.php'); ?>

<!-- Main Section -->
<div class="main-content" style="min-height: 100%;" id="manage-tables"> 
    <div class="wrapper">
        <h2 class="text-center">MANAGE RESERVATION</h2><br>

        <?php
            // Display session messages for updates and deletions
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
        ?><br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>ID Number</th>
                <th>Contact</th>
                <th>Number of People</th>
                <th>Table Name</th>
                <th>Reservation Date</th>
                <th>Reservation Time</th>
                <th>Actions</th>
            </tr>

            <?php
                // Fetch all reservations from the database
                $sql = "SELECT * FROM tbl_reservation ORDER BY reservation_id DESC";
                $res = mysqli_query($conn, $sql);

                if (!$res) {
                    die("Query failed: " . mysqli_error($conn));
                }

                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $reservation_id = $row['reservation_id'];
                        $full_name = $row['full_name'];
                        $id_no = $row['id_no'];
                        $contact = $row['contact'];
                        $table_capacity = $row['table_capacity'];
                        $table_name = $row['table_name'];
                        $reservation_date = $row['reservation_date'];
                        $reservation_time = $row['reservation_time'];
            ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $id_no; ?></td>
                            <td><?php echo $contact; ?></td>
                            <td><?php echo $table_capacity; ?></td>
                            <td><?php echo $table_name; ?></td>
                            <td><?php echo $reservation_date; ?></td>
                            <td><?php echo $reservation_time; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/delete-reservation.php?reservation_id=<?php echo $reservation_id; ?>" class="btn-danger">Delete</a>
                            </td>
                        </tr>

            <?php
                    }
                } else {
            ?>

                    <tr>
                        <td colspan="9">
                            <div class="error">No Reservations</div>
                        </td>
                    </tr>

            <?php
                }

                mysqli_close($conn); // Close the database connection
            ?>
        </table>
    </div>
    <div class="clearfix"></div>
</div>

<?php include('partials/footer.php'); ?>
