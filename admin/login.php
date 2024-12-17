<?php include('config/constant.php'); ?>

<html>
    <head>
        <title>Login - Restaurant System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <form action="" method="POST">
                <h2 class="text-center">LOGIN</h2><br><br>

                <?php

                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if (isset($_SESSION['not-login'])) {
                    echo $_SESSION['not-login'];
                    unset($_SESSION['not-login']);
                }

                if (isset($_SESSION['logout'])) {
                    echo $_SESSION['logout'];
                    unset($_SESSION['logout']);
                }

                if (isset($_SESSION['no-login-message'])) {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
                ?><br><br>

                <div class="form-group">
                    <input type="number" name="id_no" placeholder="Enter ID Number" required>
                </div>
                <div class="form-group">
                    <input type="text" name="full_name" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Login" class="btn-user">
                </div>
            </form>
        </div>
    </body>
</html>

<?php
// login process
if (isset($_POST['submit'])) {
    session_start(); // Start session to use session variables

    // Sanitize input
    $id_no = filter_input(INPUT_POST, 'id_no', FILTER_SANITIZE_NUMBER_INT);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query the database for the user
    $sql = "SELECT * FROM tbl_user WHERE id_no='$id_no' AND username='$full_name'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['login'] = "<div class='success'>Login Successful</div>";
        $_SESSION['user'] = $row['username'];

        header("location:" . SITEURL . 'admin/');
    } else {
        $_SESSION['not-login'] = "<div class='error text-center'>Incorrect ID Number, Username, or Password</div>";
        header("location:" . SITEURL . 'admin/login.php');
    }
}
?>
