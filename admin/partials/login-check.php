<?php
    // authorization for access control - check whether user is logged in or not

    if(!isset($_SESSION['user'])){
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login first to access Admin Dashboard</div>";
        header("location:" . SITEURL . 'admin/login.php');
    }
?>