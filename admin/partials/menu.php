<?php 
    include('../config/constant.php');
    include('login-check.php');
?>

<html>
    <head>
        <title>Restuarant Website - Home Page</title>

        <!-- css link -->

        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <!-- Menu Section -->
         <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="manage-tables.php">Tables</a></li>
                    <li><a href="manage-reservation.php">Reservations</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    
                </ul>
            </div>
         </div>