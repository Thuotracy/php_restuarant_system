<?php include('config/constant.php'); ?>

<html>
    <head>
        <title>Login - Restaurant System</title>
        <!-- <link rel="stylesheet" href="../css/admin.css"> -->
        <!-- <link rel="stylesheet" href="css/style.css"> -->
    </head>

    <style>
        body {
        font-family: 'Nunito', sans-serif;
        background-color: #f4f7f8;
        color: #384047;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

        .login {
        max-width: 480px;
        width: 100%;
        padding: 20px;
        background: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        text-align: center;
    }

    h2 {
        margin-bottom: 30px;
        font-size: 24px;
        color: #e67e22;
    }

    .form-group {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            background: #e8eeef;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #384047;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: #e67e22;
        }

        .btn-user {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        color: #fff;
        background-color: #e67e22;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .btn-user:hover {
            background-color: #d35400;
        }

        fieldset {
            border: none;
            margin-bottom: 20px;
        }

        legend {
            font-size: 1.4em;
            margin-bottom: 10px;
            color: #384047;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .error, .success {
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
            border-radius: 5px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        a{
            text-decoration: none;
            color: #e67e22;
            font-weight: bolder;
        }

      
        </style>

    <body>
        <div class="login">
            <form action="" method="POST">
                <h2 class="text-center">LOGIN</h2>

                <p>Don't Have An Account Yet?  <a href="<?php echo SITEURL; ?>user-signup.php">Sign Up!</a></p>

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
    $sql = "SELECT * FROM tbl_user WHERE id_no='$id_no' AND full_name='$full_name'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    if ($row && password_verify($password, $row['password'])) {
        // Store user data in session
        $_SESSION['login'] = "<div class='success'>Login Successful</div>";
        $_SESSION['user'] = $row['full_name'];
        $_SESSION['user_id'] = $row['id_no'];  // Store id_no in session

        // Redirect to homepage or other page
        header("location:" . SITEURL);
    } else {
        $_SESSION['not-login'] = "<div class='error text-center'>Incorrect ID Number, full_name, or Password</div>";
        header("location:" . SITEURL . 'user-login.php');
    }
}
?>