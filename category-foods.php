<?php include('partials-frontend/menu.php'); ?>  

<?php
    // check if category_id passed or not to display the category name

    if(isset($_GET['category_id'])){
        $category_id = $_GET['category_id'];

        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($res);

        $category_title = $row['title'];
    }
    else{
        header('location:'.SITEURL);
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white"><?php echo $category_title; ?></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>


            <?php

            // fetch all foods froom db
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

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
                                    <h4 style="color: black;"><?php echo $title; ?></h4>
                                    <p class="food-price" style="color: black;">Ksh. <?php echo $price; ?></p>
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

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-frontend/footer.php'); ?>  