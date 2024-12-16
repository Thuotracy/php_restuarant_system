<?php include('partials/menu.php'); ?>

          <!-- Main Section -->
          <div class="main-content">
            <div class="wrapper">
               <h2 class="text-center">MANAGE FOOD</h2><br><br>


               <?php
                    if (isset($_SESSION['add-food'])) {
                        echo $_SESSION['add-food'];
                        unset($_SESSION['add-food']);
                    }

                    if (isset($_SESSION['remove-img'])) {
                        echo $_SESSION['remove-img'];
                        unset($_SESSION['remove-img']);
                    }

                    if (isset($_SESSION['delete-food'])) {
                        echo $_SESSION['delete-food'];
                        unset($_SESSION['delete-food']);
                    }

                    if (isset($_SESSION['remove-food'])) {
                        echo $_SESSION['remove-food'];
                        unset($_SESSION['remove-food']);
                    }

                    if (isset($_SESSION['upload'])) {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }


                    if (isset($_SESSION['update'])) {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                
                ?><br><br>

               <!-- btn to add food -->

               <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a><br><br><br>

               <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Food Title</th>
                    <th>Food Price</th>
                    <th>Food Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>


                <?php
                    // fetch all food from db and display

                    $sql = "SELECT * FROM tbl_food";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                      // create a variable and assign the value
                      $sn=1;


                    if($count>0){
                        while($row=mysqli_fetch_assoc($res)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $title ?></td>
                                    <td><?php echo $price ?></td>


                                    <td>

                                        <?php 
                                            // display image
                                            if($image_name!=""){
                                                ?>
                                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name ?>" width="100px">
                                                <?php
                                            }
                                            else{
                                                echo "<div class='error'>Image Not Available</div>";
                                            }
                                        ?>

                                    </td>


                                    <td><?php echo $featured ?></td>
                                    <td><?php echo $active ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id ?>" class="btn-secondary">Update</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id ?>&image_name=<?php echo $image_name ?>" class="btn-danger">Delete</a>
                                    </td>
                                </tr>

                            <?php
                        }
                    }
                    else{
                        ?>

                        <tr>
                            <td colspan="6">
                                <div class="error">No Food Added</div>
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