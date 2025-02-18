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
$full_name = $_SESSION['user'];

// Fetch the user's ID and contact information from the database
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if (empty($user_id)) {
    $_SESSION['no-login-message'] = "<div class='error text-center'>Session expired. Please log in again.</div>";
    header('Location: ' . SITEURL . 'user-login.php');
    exit;
}

$sql_user = "SELECT id_no, contact FROM tbl_user WHERE id_no = '$user_id'";
$res_user = mysqli_query($conn, $sql_user);

$user_data = [
    'id_no' => '',
    'contact' => ''
];

if ($res_user && mysqli_num_rows($res_user) == 1) {
    $user_data = mysqli_fetch_assoc($res_user);
} else {
    $_SESSION['no-login-message'] = "<div class='error text-center'>User data not found. Please log in again.</div>";
    header('Location: ' . SITEURL . 'user-login.php');
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $id_no = mysqli_real_escape_string($conn, $_POST['id_no']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $table_capacity = mysqli_real_escape_string($conn, $_POST['table_capacity']);
    $reservation_date = mysqli_real_escape_string($conn, $_POST['reservation_date']);
    $reservation_time = mysqli_real_escape_string($conn, $_POST['reservation_time']);
    $table_name = mysqli_real_escape_string($conn, $_POST['table_name']);

    $sql = "INSERT INTO tbl_reservation (full_name, id_no, contact, table_capacity, reservation_date, reservation_time, table_name) 
            VALUES ('$full_name', '$id_no', '$contact', '$table_capacity', '$reservation_date', '$reservation_time', '$table_name')";

    $res = mysqli_query($conn, $sql);
    if ($res) {
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

<section class="food-search2">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your Reservation.</h2>

        <form action="" method="POST" class="order">
            <fieldset style="color: white;">
                <legend>Reservation Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full_name" class="input-responsive" required value="<?php echo htmlspecialchars($full_name); ?>">

                <div class="order-label">ID Number</div>
                <input type="number" name="id_no" class="input-responsive" required value="<?php echo htmlspecialchars($user_data['id_no']); ?>">

                <div class="order-label">Phone Number</div>
                <input type="number" name="contact" class="input-responsive" required value="<?php echo htmlspecialchars($user_data['contact']); ?>">

                <div class="order-label">Number of People</div>
                <input type="text" id="table_capacity" name="table_capacity" class="input-responsive" required>
                <button type="button" id="find_tables" class="btn">Find Tables</button><br><br>

                <div class="order-label">Table Name</div>
                <select id="table_name" name="table_name" class="input-responsive" required>
                    <option value="" disabled selected>Select a Free Table</option>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#find_tables').click(function() {
        var capacity = $('#table_capacity').val();
        if (capacity === '') {
            alert('Please enter the number of people first.');
            return;
        }

        $.ajax({
            url: 'fetch_tables.php',
            type: 'POST',
            data: { table_capacity: capacity },
            success: function(response) {
                $('#table_name').html(response);
            }
        });
    });
});
</script>

<?php include('partials-frontend/footer.php'); ?>
