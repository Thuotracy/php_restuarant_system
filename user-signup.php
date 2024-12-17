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
                <h2 class="text-center">SIGN UP</h2>
                <p>Already Have An Account?  <a href="<?php echo SITEURL; ?>user-login.php">Login!</a></p>
            <!-- show success message -->

            <?php
                if(isset($_SESSION['add-user'])){
                    echo $_SESSION['add-user'];
                    unset($_SESSION['add-user']);
                }
            ?>


                <div class="form-group">
                    <input type="number" name="id_no" placeholder="Enter ID Number" required>
                </div>
                <div class="form-group">
                    <input type="text" name="full_name" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <input type="number" name="contact" placeholder="Enter Contact" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Sign Up" class="btn-user">
                </div>
            </form>
        </div>
    </body>
</html>


<?php
if (isset($_POST['submit'])) {
    $id_no = $_POST['id_no'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO tbl_user (id_no, full_name, email, contact, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $id_no, $full_name, $email, $contact ,$password);

    if ($stmt->execute()) {
        $_SESSION['add-user'] = "<div class='success'>User Created Successfully</div>";
        header("location:" . SITEURL . 'user-login.php');
    } else {
        $_SESSION['add-user'] = "<div class='error'>Failed to Create User</div>";
        header("location:" . SITEURL . 'user-signup.php');
    }
    $stmt->close();
}
?>
