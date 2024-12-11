<?php include('../config/constant.php') ?>

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
                    <input type="text" name="username" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Login" class="btn-secondary">
                </div>
            </form>
        </div>
    </body>
</html>

<?php
// login process
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query the database for the user
    $sql = "SELECT * FROM tbl_admin WHERE username='$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['login'] = "<div class='success'>Login Successful</div>";

        $_SESSION['user'] = $username;

        header("location:" . SITEURL . 'admin/');
    } else {
        $_SESSION['not-login'] = "<div class='error text-center'>Incorrect Username or Password</div>";
        header("location:" . SITEURL . 'admin/login.php');
    }
}
?>
