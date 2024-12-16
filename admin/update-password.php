<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h2 class="text-center">CHANGE PASSWORD</h2><br><br>

        <!-- Show success or error messages -->
        <?php
            if (isset($_SESSION['user-not-found'])) {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }

            if (isset($_SESSION['pwd-not-match'])) {
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
            }

            if (isset($_SESSION['change-pwd-fail'])) {
                echo $_SESSION['change-pwd-fail'];
                unset($_SESSION['change-pwd-fail']);
            }

            if (isset($_SESSION['current-pwd-incorrect'])) {
                echo $_SESSION['current-pwd-incorrect'];
                unset($_SESSION['current-pwd-incorrect']);
            }
        ?>

        <?php 
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <input type="password" name="current_password" placeholder="Current Password">
            </div>
            <div class="form-group">
                <input type="password" name="new_password" placeholder="New Password">
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Change Password" class="btn">
            </div>
        </form>
    </div>
</div>

<?php
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Fetch the user from the database
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if ($res == TRUE) {
            $count = mysqli_num_rows($res);
        
            if ($count == 1) {
                // Admin found
                $row = mysqli_fetch_assoc($res);
                $stored_password = $row['password'];
        
                // Verify the current password
                if (password_verify($current_password, $stored_password)) {
                    // Check if new password and confirm password match
                    if ($new_password === $confirm_password) {
                        // Hash the new password
                        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        
                        // Update the password in the database
                        $update_sql = "UPDATE tbl_admin SET password='$hashed_password' WHERE id=$id";
                        $update_res = mysqli_query($conn, $update_sql);
        
                        if ($update_res == TRUE) {
                            $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully</div>";
                            header("location:" . SITEURL . 'admin/manage-admin.php');
                            exit(); // Ensure script stops after redirection
                        } else {
                            $_SESSION['change-pwd-fail'] = "<div class='error'>Failed to Change Password</div>";
                            header("location:" . SITEURL . 'admin/update-password.php');
                            exit();
                        }
                    } else {
                        // New password and confirm password do not match
                        $_SESSION['pwd-not-match'] = "<div class='error'>New Password and Confirm Password do not match</div>";
                        header("location:" . SITEURL . 'admin/update-password.php');
                        exit();
                    }
                } else {
                    $_SESSION['current-pwd-incorrect'] = "<div class='error'>Current Password is Incorrect</div>";
                    header("location:" . SITEURL . 'admin/update-password.php');
                    exit();
                }
            } else {
                // Admin not found
                $_SESSION['user-not-found'] = "<div class='error'>Admin Not Found</div>";
                header("location:" . SITEURL . 'admin/update-password.php');
                exit();
            }
        } else {
            // Query failed
            // $_SESSION['user-not-found'] = "<div class='error'>Error in fetching admin data</div>";
            // header("location:" . SITEURL . 'admin/manage-admin.php');
            // exit();
        }
    }      
?>

<?php include('partials/footer.php');?>
