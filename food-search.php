<?php include('partials-frontend/menu.php'); ?>  

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>"</a></h2>
    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<!-- FOOD MENU Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
            // Check if search input is provided
            if (!empty($_POST['search'])) {
                // Fetch search input
                $search = mysqli_real_escape_string($conn, $_POST['search']);

                // SQL query to fetch matching food items
                $sql = "SELECT * FROM tbl_food WHERE title LIKE ? OR description LIKE ?";
                $stmt = $conn->prepare($sql);
                $searchParam = '%' . $search . '%';
                $stmt->bind_param("ss", $searchParam, $searchParam);
                $stmt->execute();
                $res = $stmt->get_result();

                // Check if any food items found
                if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    if (empty($image_name)) {
                                        echo "<div class='error'>Image Not Available</div>";
                                    } else {
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" 
                                             alt="<?php echo htmlspecialchars($title); ?>" 
                                             class="img-responsive img-curve" 
                                             width="80px" height="80px">
                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo htmlspecialchars($title); ?></h4>
                                <p class="food-price"><?php echo htmlspecialchars($price); ?></p>
                                <p class="food-detail"><?php echo htmlspecialchars($description); ?></p>
                                <br>
                                <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<div class='error'>No Food Found</div>";
                }

                $stmt->close();
            } else {
                echo "<div class='error'>Please enter a search term.</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- FOOD MENU Section Ends Here -->

<?php include('partials-frontend/footer.php'); ?>  
