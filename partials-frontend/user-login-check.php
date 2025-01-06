<?php
    // authorization for access control - check whether user is logged in or not

    if(!isset($_SESSION['user'])){
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login first to access Website</div>";
        header("location:" . SITEURL . 'user-login.php');
    }
?>