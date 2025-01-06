<?php

    include('config/constant.php');


    $_SESSION['logout'] = "<div class='success'>You have successfully logged out.</div>";
    session_destroy();
    header("location:" . SITEURL . 'user-login.php');

?>