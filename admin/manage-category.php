<?php include('partials/menu.php'); ?>

          <!-- Main Section -->
          <div class="main-content">
            <div class="wrapper">
               <h2>MANAGE CATEGORY</h2><br><br>

               <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                ?><br><br>

               <!-- btn to add admin -->

               <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a><br><br>


               <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>


                <?php
                    // fetch categories from db and display

                    $sql = "SELECT * FROM tbl_category";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                      // create a variable and assign the value
                      $sn=1;


                    if($count>0){
                        while($row=mysqli_fetch_assoc($res)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $title ?></td>


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
                                        <a href="#" class="btn-secondary">Update</a>
                                        <a href="#" class="btn-danger">Delete</a>
                                    </td>
                                </tr>

                            <?php
                        }
                    }
                    else{
                        ?>

                        <tr>
                            <td colspan="6">
                                <div class="error">No Category Added</div>
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