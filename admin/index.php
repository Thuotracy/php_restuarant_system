<?php include('partials/menu.php'); ?>

          <!-- Main Section -->
          <div class="main-content">
            <div class="wrapper">
               <h2 class="text-center">DASHBOARD</h2><br><br>

               <?php
                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                ?><br><br>

                <div class="col-4 text-center">
                <?php  
                        $sql = "SELECT * FROM  tbl_admin";

                        $res = mysqli_query($conn, $sql);

                        $count = mysqli_num_rows($res);
                    ?>

                    <h2><?php echo $count; ?></h2><br/>
                    Admin
                </div>

                <div class="col-4 text-center">

                    <?php  
                        $sql = "SELECT * FROM  tbl_category";

                        $res = mysqli_query($conn, $sql);

                        $count = mysqli_num_rows($res);
                    ?>

                    <h2><?php echo $count; ?></h2><br/>
                    Categories
                </div>

                <div class="col-4 text-center">
                <?php  
                    $sql = "SELECT * FROM  tbl_food";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);
                ?>

                    <h2><?php echo $count; ?></h2><br/>
                    Food
                </div>

                <div class="col-4 text-center">
                <?php  
                    $sql = "SELECT * FROM  tbl_order";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);
                ?>

                    <h2><?php echo $count; ?></h2><br/>
                    Orders
                </div>
            </div>

            <div class="clearfix"></div>
         </div>

<?php include('partials/footer.php');?>          