<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>UPDATE ORDER</h2><br><br>

        <?php
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        
        ?><br><br>

        <?php
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = mysqli_real_escape_string($conn, $_GET['id']);

            // Fetch order details
            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            $res = mysqli_query($conn, $sql);

            if ($res && mysqli_num_rows($res) == 1) {
                $row = mysqli_fetch_assoc($res);

                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_address = $row['customer_address'];
            } else {
                $_SESSION['order-not-found'] = "Order not found!";
                header('location:' . SITEURL . 'admin/manage-order.php');
                exit();
            }
        } else {
            header('location:' . SITEURL . 'admin/manage-order.php');
            exit();
        }

        if (isset($_POST['submit'])) {
            // Get form data
            $id = intval($_POST['id']);
            $qty = intval($_POST['qty']);
            $price = floatval($_POST['price']);
            $total = $price * $qty;
            $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
            $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
            $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);
            $status = mysqli_real_escape_string($conn, $_POST['status']);

           

            // Update order in database
            $sql2 = "UPDATE tbl_order SET 
                        qty=$qty, 
                        price=$price, 

                        total=$total,
                        
                        customer_name='$customer_name', 
                        customer_contact='$customer_contact', 
                        customer_address='$customer_address', 
                        status='$status' 
                    WHERE id=$id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2==TRUE) {
                $_SESSION['update'] ="<div class='success text-center'>Order updated successfully!</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            } else {
                $_SESSION['update'] ="<div class='error text-center'>Failed to updated order.</div>";
                header('location:' . SITEURL . 'admin/update-order.php');
            }
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <form action="" method="POST">
                    <fieldset>
                        <legend><span class="number">1</span> Order <?php echo $id ?></legend>
                        
                        <label for="food">Food:</label>
                        <p><b><?php echo $food; ?></b></p><br>

                        <label for="price">Price:</label>
                        <p><b>Ksh. <?php echo $price; ?></b></p><br>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <label for="qty">Quantity:</label>
                        <input type="number" name="qty" value="<?php echo $qty; ?>" min="1" required>

                        <label for="customer_name">Customer Name:</label>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" required>

                        <label for="customer_contact">Customer Contact:</label>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>" required>

                        <label for="customer_address">Customer Address:</label>
                        <input type="text" name="customer_address" value="<?php echo $customer_address; ?>" required>

                        <label for="status">Status:</label>
                        <select name="status" required>
                            <option value="Ordered" <?php if ($status == "ordered") echo "selected"; ?>>Ordered</option>
                            <option value="On Delivery" <?php if ($status == "on_delivery") echo "selected"; ?>>On Delivery</option>
                            <option value="Delivered" <?php if ($status == "delivered") echo "selected"; ?>>Delivered</option>
                            <option value="Cancelled" <?php if ($status == "cancelled") echo "selected"; ?>>Cancelled</option>
                        </select>
                    </fieldset>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                    <input type="submit" name="submit" value="Update Order" class="btn">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>
