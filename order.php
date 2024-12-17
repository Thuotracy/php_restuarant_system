<?php include('partials-frontend/menu.php'); ?>  

<?php
    if (isset($_GET['food_id'])) {
        $food_id = $_GET['food_id'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM tbl_food WHERE id = ?");
        $stmt->bind_param("i", $food_id);
        $stmt->execute();
        $res = $stmt->get_result();

        $count = $res->num_rows;

        if ($count == 1) {
            $row = $res->fetch_assoc();

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        } else {
            header('location:' . SITEURL); 
            exit();
        }
    } else {
        header('location:' . SITEURL);
        exit();
    }
    

    // Display session message if set
    if (isset($_SESSION['order']) && !empty($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search2">
        <div class="container">
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>
                    <?php
                    if (empty($image_name)) {
                        echo "<div class='error'>Image Not Available</div>";
                    } else {
                        ?>
                        <div class="food-item">
                            <div class="food-img">
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo htmlspecialchars($image_name); ?>" 
                                    alt="Selected Food" 
                                    class="img-responsive img-curve">
                            </div>
                            <div class="food-menu-desc">
                                <h3><?php echo htmlspecialchars($title); ?></h3>
                                <input type="hidden" name="food" value="<?php echo htmlspecialchars($title); ?>">

                                <p class="food-price">Ksh. <?php echo htmlspecialchars($price); ?></p>
                                <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">

                                <div class="order-label">Quantity</div>
                                <input type="number" name="qty" class="input-responsive" value="1" required>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </fieldset>

                <fieldset style="color: white;">
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Tracy Wangari" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="0700000000" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="tracy@gmail.com class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                $food = $_POST['food'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty;
                $order_date = date("Y-m-d H:i:s");
                $status = "Ordered";

                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];

                // Use prepared statements for inserting order details
                $stmt2 = $conn->prepare("INSERT INTO tbl_order SET 
                    food = ?, price = ?, qty = ?, total = ?, order_date = ?, 
                    status = ?, customer_name = ?, customer_contact = ?, 
                    customer_email = ?, customer_address = ?");
                $stmt2->bind_param(
                    "siiissssss", 
                    $food, $price, $qty, $total, $order_date, 
                    $status, $customer_name, $customer_contact, 
                    $customer_email, $customer_address
                );

                if ($stmt2->execute()) {
                    $_SESSION['order'] = "<div class='success text-center'>Order Placed Successfully</div>";
                    header("location:" . SITEURL);
                } else {
                    $_SESSION['order'] = "<div class='error text-center'>Failed to Place Order</div>";
                    header("location:" . SITEURL . 'admin/order.php');
                }
            }
?>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-frontend/footer.php'); ?>  
