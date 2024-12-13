<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1><br><br>

        <?php
                if(isset($_SESSION['food-not-found'])){
                    echo $_SESSION['food-not-found'];
                    unset($_SESSION['food-not-found']);
                }

                // if(isset($_SESSION['remove'])){
                //     echo $_SESSION['remove'];
                //     unset($_SESSION['remove']);
                // }

                // if(isset($_SESSION['delete'])){
                //     echo $_SESSION['delete'];
                //     unset($_SESSION['delete']);
                // }
        ?><br><br>


        <?php
            // Fetch food data to display in the form
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Fetch data using prepared statements
                $stmt = $conn->prepare("SELECT * FROM tbl_food WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res->num_rows == 1) {
                    $row = $res->fetch_assoc();
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $current_image = $row['image_name'];
                    $current_category = $row['category_id'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } else {
                    $_SESSION['food-not-found'] = "<div class='error'>Food not found.</div>";
                    header("location:" . SITEURL . 'admin/update-food.php');
                    exit();
                }
            } else {
                header("location:" . SITEURL . 'admin/manage-food.php');
                exit();
            }
        ?> 

      

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Food Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
            </div>

            <div class="form-group">
                <label for="title">Food Description</label>
                <textarea name="description" id="description" cols="30" rows="5" value="<?php echo htmlspecialchars($description); ?>"></textarea>
            </div>

            <div class="form-group">
                <label for="title">Food Price</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
            </div>

            <div class="form-group">
                <label for="title">Current Image</label>
                <td>
                <?php
                    if($current_image != ""){
                        ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="Food Image" width="150">
                        <?php
                    } else {
                        echo "<div class='error'>Image Not Available</div>";
                    }
                ?>
                </td>
            </div>

            <div class="form-group">
                <label for="title">New Image</label>
                <input type="file" id="image" name="image">
            </div>

            <div class="form-group">
                <label for="category">Food Category</label>
                <select name="category" id="category">
                    <?php
                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    if($count>0){
                        while($row=mysqli_fetch_assoc($res)){
                            $category_title = $row['title'];
                            $category_id = $row['id'];

                            ?>

                            <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title;?></option>

                            <?php
                        }
                    }
                    else{
                        echo "<option value='0>Category Not Available</option>";
                    }
                    ?>
                </select>
            </div>

            <table>
                <tr>
                    <td>Featured</td>
                    <td>
                    <input type="radio" name="featured" value="Yes" id="featured-yes" <?php if ($featured == "Yes") echo "checked"; ?>> <label for="featured-yes">Yes</label>
                    <input type="radio" name="featured" value="No" id="featured-no" <?php if ($featured == "No") echo "checked"; ?>> <label for="featured-no">No</label>

                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                    <input type="radio" name="active" value="Yes" id="active-yes" <?php if ($active == "Yes") echo "checked"; ?>> <label for="active-yes">Yes</label>
                    <input type="radio" name="active" value="No" id="active-no" <?php if ($active == "No") echo "checked"; ?>> <label for="active-no">No</label>
                    </td>
                </tr>
            </table>

            <div class="form-group">
                
                <input type="submit" name="submit" value="Update Food" class="btn-secondary">
            </div>
        </form>

        <?php
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];
            
                if (in_array($ext, $allowed_extensions)) {
                    $new_image_name = "Category_".rand(000, 999).'.'.$ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$new_image_name;
            
                    $upload = move_uploaded_file($source_path, $destination_path);
                    if (!$upload) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                    }
                } else {
                    $_SESSION['upload'] = "<div class='error'>Invalid File Format.</div>";
                    header('location:'.SITEURL.'admin/update-food.php');
                    die();
                }
            } else {
                $new_image_name = $current_image; // Use the current image if no new image is uploaded
            }
            
        ?>


        <?php
            if (isset($_POST['submit'])) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
            
                $stmt = $conn->prepare("UPDATE tbl_food SET title = ?, description = ?, price = ?, image_name = ?, category_id = ?, featured = ?, active = ? WHERE id = ?");
                $stmt->bind_param("ssisissi", $title, $description, $price, $new_image_name, $category, $featured, $active, $id);
            
                $result = $stmt->execute();
                if ($result) {
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header("location:" . SITEURL . 'admin/manage-food.php');
                } else {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                    header("location:" . SITEURL . 'admin/update-food.php');
                }
            }
            
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>