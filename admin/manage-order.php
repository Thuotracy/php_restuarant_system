<?php include('partials/menu.php'); ?>

          <!-- Main Section -->
          <div class="main-content" managestyle="min-height: 100%;"-tables.php">
            <div class="wrapper">
               <h2 class="text-center">MANAGE ORDER</h2><br>

               <?php
                    if (isset($_SESSION['update'])) {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                ?><br><br>




               <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>


                <?php
                    // fetch all orders from db and display

                    $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //display the latest order first

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                      // create a variable and assign the value
                      $sn=1;


                    if($count>0){
                        while($row=mysqli_fetch_assoc($res)){
                            $id = $row['id'];
                            $food = $row['food'];
                            $price = $row['price'];
                            $qty = $row['qty'];
                            $total = $row['total'];
                            $order_date = $row['order_date'];
                            $status = $row['status'];
                            $customer_name = $row['customer_name'];
                            $customer_contact = $row['customer_contact'];
                            $customer_email = $row['customer_email'];
                            $customer_address = $row['customer_address'];
                            

                            ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $food ?></td>
                                    <td><?php echo $price ?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td>Ksh. <?php echo $total ?></td>
                                    <td><?php echo $order_date ?></td>
                                    <td><?php
                                        if($status=="Ordered")
                                        {
                                            echo "<label style='color: blue'>$status</label>";
                                        }
                                        elseif($status=="On Delivery")
                                        {
                                            echo "<label style='color: orange'>$status</label>";
                                        }
                                        elseif($status=="Delivered")
                                        {
                                            echo "<label style='color: green'>$status</label>";
                                        }
                                        elseif($status=="Cancelled")
                                        {
                                            echo "<label style='color: red'>$status</label>";
                                        }
                                    ?></td>
                                    <td><?php echo $customer_name ?></td>
                                    <td><?php echo $customer_contact ?></td>
                                    <td><?php echo $customer_email ?></td>
                                    <td><?php echo $customer_address ?></td>


                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id ?>" class="btn-secondary">Update</a>
                                    </td>
                                </tr>

                            <?php
                        }
                    }
                    else{
                        ?>

                        <tr>
                            <td colspan="6">
                                <div class="error">No Orders</div>
                            </td>
                        </tr>

                        <?php
                    }
                ?>


               </table>

               
            </div>

            <div class="clearfix"></div>
         </div>

<?php include('partials/footer.php'); ?>