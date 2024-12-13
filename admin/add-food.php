<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1><br><br>

        <!-- Show success message -->
        <?php
        // if (isset($_SESSION['add-food'])) {
        //     echo $_SESSION['add-food'];
        //     unset($_SESSION['add-food']);
        // }

        
        ?><br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Food Title</label>
                <input type="text" id="title" name="title" placeholder="Food Title" required>
            </div>

            <div class="form-group">
                <label for="title">Food Description</label>
                <textarea name="description" id="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
            </div>

            <div class="form-group">
                <label for="title">Food Price</label>
                <input type="number" id="price" name="price" placeholder="Food price" required>
            </div>

            <div class="form-group">
                <label for="title">Upload Image</label>
                <input type="file" id="image" name="image">
            </div>

            <table>
                <tr>
                    <td>Food Category</td>
                    <td>
                        <select name="category" id="category">

                            <?php
                                // code to check if there are any existing categories
                                // only active categories will be shown in the food dropdown

                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                $res = mysqli_query($conn, $sql);

                                $count = mysqli_num_rows($res);

                                if($count>0){
                                    
                                    while($row=mysqli_fetch_assoc($res)){
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
 
                                        <?php
                                    }

                                }
                                else{
                                    ?>
                                        <option value="0">No Category Found</option>

                                    <?php
                                }
                            
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <br>

            <table>
                <tr>
                    <td>Featured</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" id="featured-yes"> <label for="featured-yes">Yes</label>
                        <input type="radio" name="featured" value="No" id="featured-no"> <label for="featured-no">No</label>
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes" id="active-yes"> <label for="active-yes">Yes</label>
                        <input type="radio" name="active" value="No" id="active-no"> <label for="active-no">No</label>
                    </td>
                </tr>
            </table>

            <div class="form-group">
                <input type="submit" name="submit" value="Add Food" class="btn-secondary">
            </div>
        </form>

        <?php
            if (isset($_POST['submit'])) {
                $title = trim($_POST['title']);
                $description = trim($_POST['description']);
                $price = trim($_POST['price']);
                $category = trim($_POST['category']);
                $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
                $active = isset($_POST['active']) ? $_POST['active'] : "No";
                $image_name = "";
            
                // Handle image upload
                if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                    $image_name = $_FILES['image']['name'];
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;
            
                    if (!move_uploaded_file($source_path, $destination_path)) {
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                        header("location:" . SITEURL . 'admin/add-food.php');
                        exit;
                    }
                }
            
                // Check database connection
                if (!$conn || $conn->connect_error) {
                    die("Database connection failed: " . $conn->connect_error);
                }
            
                // Prepare and execute the SQL query
                $stmt = $conn->prepare("INSERT INTO tbl_food (title, description, price, category_id, image_name, featured, active) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if (!$stmt) {
                    die("Statement preparation failed: " . $conn->error);
                }
            
                $stmt->bind_param("ssissss", $title, $description, $price, $category, $image_name, $featured, $active);
            
                if ($stmt->execute()) {
                    $_SESSION['add-food'] = "<div class='success'>Food Added Successfully</div>";
                    header("location:" . SITEURL . 'admin/manage-food.php');
                } else {
                    $_SESSION['add-food'] = "<div class='error'>Failed to Add Food: " . $stmt->error . "</div>";
                    header("location:" . SITEURL . 'admin/add-food.php');
                }
                $stmt->close();
            }
            

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
