<?php include('partials/menu.php');?>

          <!-- Main Section -->
          <div class="main-content">
            <div class="wrapper">
               <h2 class="text-center">MANAGE TABLES</h2><br>

               <!-- show success message -->
                <?php
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                ?>

                <br><br><br>

               <!-- btn to add table -->

               <a href="add-table.php" class="btn-primary">Add table</a><br><br><br>

               <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Table Name</th>
                    <th>Table Capacity</th>
                    <th>Table Status</th>
                    <th>Actions</th>
                </tr>

                <?php
                    // get table from db and display
                    $sql = "SELECT * FROM tbl_table";

                    $res = mysqli_query($conn, $sql);

                    if($res==TRUE){
                        $count = mysqli_num_rows($res);

                        // create a variable and assign the value
                        $sn=1;

                        if($count>0){
                            while($rows=mysqli_fetch_assoc($res)){
                                $table_name=$rows['table_name'];
                                $table_capacity=$rows['table_capacity'];
                                $table_status=$rows['table_status'];
                ?>


                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $table_name ?></td>
                    <td><?php echo $table_capacity ?> People</td>
                    <td><?php
                            if($table_status=="Free")
                            {
                                echo "<label style='color: green'>$table_status</label>";
                            }
                            elseif($table_status=="Occupied")
                            {
                                echo "<label style='color: red'>$table_status</label>";
                            }
                            elseif($table_status=="Reserved")
                            {
                                echo "<label style='color: blue'>$table_status</label>";
                            }
                            
                        ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update-table.php?table_name=<?php echo $table_name ?>" class="btn-secondary">Update</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-table.php?table_name=<?php echo $table_name ?>" class="btn-danger">Delete</a>
                    </td>
                </tr>


                <?php
                            }
                        }
                    }
                    else{
                        
                    }
                ?>   
                
               </table>

               
            </div>

            <div class="clearfix"></div>
         </div>

 <?php include('partials/footer.php');?>        