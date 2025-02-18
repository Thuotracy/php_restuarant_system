<?php
session_start(); // Start the session to access session variables
include('partials-frontend/menu.php'); 

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please log in to make a reservation.</div>";
    header('Location: ' . SITEURL . 'user-login.php');
    exit;
}

// Retrieve full name from session
$full_name = $_SESSION['user'];  // The user's full name stored during login

// Fetch the user's ID and contact information from the database (assuming user_id is in the session)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; // Get user ID from session

// If user_id is not set, stop further execution
if (empty($user_id)) {
    $_SESSION['no-login-message'] = "<div class='error text-center'>Session expired. Please log in again.</div>";
    header('Location: ' . SITEURL . 'user-login.php');
    exit;
}

// Query to fetch user data based on id_no (assuming id_no is the unique identifier)
$sql_user = "SELECT id_no, contact FROM tbl_user WHERE id_no = '$user_id'";
$res_user = mysqli_query($conn, $sql_user);

// Initialize user details
$user_data = [
    'id_no' => '',
    'contact' => ''
];

// Check if the query executed successfully and user data exists
if ($res_user && mysqli_num_rows($res_user) == 1) {
    $user_data = mysqli_fetch_assoc($res_user);
} else {
    // If no user data is found, redirect to login
    $_SESSION['no-login-message'] = "<div class='error text-center'>User data not found. Please log in again.</div>";
    header('Location: ' . SITEURL . 'user-login.php');
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $id_no = mysqli_real_escape_string($conn, $_POST['id_no']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $table_capacity = mysqli_real_escape_string($conn, $_POST['table_capacity']);
    $reservation_date = mysqli_real_escape_string($conn, $_POST['reservation_date']);
    $reservation_time = mysqli_real_escape_string($conn, $_POST['reservation_time']);
    $table_name = mysqli_real_escape_string($conn, $_POST['table_name']);

    // Insert reservation data
    $sql = "INSERT INTO tbl_reservation (full_name, id_no, contact, table_capacity, reservation_date, reservation_time, table_name) 
            VALUES ('$full_name', '$id_no', '$contact', '$table_capacity', '$reservation_date', '$reservation_time', '$table_name')";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        // Update table status to 'Reserved'
        $update_table_sql = "UPDATE tbl_table SET table_status = 'Reserved' WHERE table_name = '$table_name'";
        $update_res = mysqli_query($conn, $update_table_sql);

        if ($update_res) {
            $_SESSION['reservation'] = "<div class='success text-center'>Reservation made successfully!</div>";
            header('Location: ' . SITEURL);
            exit;
        } else {
            $_SESSION['reservation'] = "<div class='error text-center'>Failed to update table status. Try again later.</div>";
        }
    } else {
        $_SESSION['reservation'] = "<div class='error text-center'>Failed to make reservation. Try again later.</div>";
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
                
                <!-- Full Name Field -->
                <div class="order-label">Full Name</div>
                <input type="text" name="full_name" placeholder="Tracy Wangari" class="input-responsive" required value="<?php echo htmlspecialchars($full_name); ?>">

                <!-- ID Number Field -->
                <div class="order-label">ID Number</div>
                <input type="number" name="id_no" placeholder="12345678" class="input-responsive" required value="<?php echo htmlspecialchars($user_data['id_no']); ?>">

                <!-- Phone Number Field -->
                <div class="order-label">Phone Number</div>
                <input type="number" name="contact" placeholder="0700000000" class="input-responsive" required value="<?php echo htmlspecialchars($user_data['contact']); ?>">

                <!-- Number of People Field -->
                <div class="order-label">Number of People</div>
                <input type="number" name="table_capacity" placeholder="4 People" class="input-responsive" required>

                <!-- Table Name Field -->
                <div class="order-label">Table Name</div>
                <select name="table_name" class="input-responsive" required>
                    <option value="" disabled selected>Select a Free Table</option>
                    <?php
                    // Fetch tables with status 'Free'
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

                <!-- Date Field -->
                <div class="order-label">Date</div>
                <input type="date" name="reservation_date" class="input-responsive" required>

                <!-- Time Field -->
                <div class="order-label">Time</div>
                <input type="time" name="reservation_time" class="input-responsive" required>

                <!-- Submit Button -->
                <input type="submit" name="submit" value="Make Reservation" class="btn">
            </fieldset>
        </form>
    </div>
</section>
<!-- Reservation Form Section Ends Here -->

<?php include('partials-frontend/footer.php'); ?>