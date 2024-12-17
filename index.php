<?php include('partials-frontend/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            

            <h1>Enjoy fresh, delicious dishes. Reserve a table or order online today!</h1><br><br><br><br>
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section><br><br>
    

    <?php
        
        if(isset($_SESSION['order'])){
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?><br><br><br>

    <div class="row">
    
        <div class="form2" action="">
           <h2>About Us</h2> <br>
           <p>
                Welcome to Plated, where passion for food meets exceptional dining experiences. Founded in 2018, our restaurant is built on the simple philosophy of bringing people together to share authentic, delicious, and memorable meals. <br><br>

                At Plated, we celebrate fresh, locally sourced ingredients crafted into dishes that delight the senses. Our menu is a fusion of classic and contemporary cuisine, inspired by culinary traditions from around the globe and crafted with love by our skilled chefs. <br><br>

                Our mission is to create a warm and inviting atmosphere where friends, family, and food lovers can gather to enjoy high-quality dishes paired with exceptional service. Whether it’s a casual lunch, a romantic dinner, or a special celebration, we strive to make every moment special.
            </p>
        </div>

        <div class="image">
            <img src="images/aboutus.jpg" alt="">
        </div>

    </div>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php  
                // fetch all categories from db
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 6";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count>0){
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];

                        ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">

                                    <?php 
                                        if($image_name == ""){
                                            echo "<div class='error'>Image Not Available</div>";
                                        }
                                        else{
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve" width="150px" height="300px">
                                            <?php
                                        }
                                    ?>

                                
                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                        <?php
                    }
                }
                else{
                    echo "<div class='error'>No Category Found.</div>";
                }
            ?>

           

       

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>


                <?php

                // fetch all foods froom db
                    $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

                    $res2 = mysqli_query($conn, $sql2);

                    $count2 = mysqli_num_rows($res2);

                    if($count2>0){
                        while($row=mysqli_fetch_assoc($res2)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $description = $row['description'];
                            $image_name = $row['image_name']; 

                            ?>

                                <div class="food-menu-box">
                                    <div class="food-menu-img">
                                    <?php 
                                        if($image_name == ""){
                                            echo "<div class='error'>Image Not Available</div>";
                                        }
                                        else{
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve" width="80px" height="80px">
                                            <?php
                                        }
                                    ?>

                                    </div>

                                    <div class="food-menu-desc">
                                        <h4><?php echo $title; ?></h4>
                                        <p class="food-price"><?php echo $price; ?></p>
                                        <p class="food-detail">
                                        <?php echo $description; ?>
                                        </p>
                                        <br>

                                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                    </div>
                                </div>

                            <?php
                        }
                    }
                    else{
                        echo "<div class='error'>No Food Found</div>";
                    }
                ?>


            


            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>

    <?php include('partials-frontend/footer.php'); ?>  