<?php include('partials/menu.php'); ?>

          <!-- Main Section -->
          <div class="main-content">
            <div class="wrapper">
               <h2>DASHBOARD</h2><br><br>

               <?php
                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                ?><br><br>

                <div class="col-4 text-center">
                    <h2>5</h2><br/>
                    Categories
                </div>

                <div class="col-4 text-center">
                    <h2>5</h2><br/>
                    Categories
                </div>

                <div class="col-4 text-center">
                    <h2>5</h2><br/>
                    Categories
                </div>

                <div class="col-4 text-center">
                    <h2>5</h2><br/>
                    Categories
                </div>
            </div>

            <div class="clearfix"></div>
         </div>

<?php include('partials/footer.php');?>          