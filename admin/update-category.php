<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1><br><br>

        <?php
                if(isset($_SESSION['category-not-found'])){
                    echo $_SESSION['category-not-found'];
                    unset($_SESSION['category-not-found']);
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
            // Fetch category data to display in the form
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Fetch data using prepared statements
                $stmt = $conn->prepare("SELECT * FROM tbl_category WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res->num_rows == 1) {
                    $row = $res->fetch_assoc();
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } else {
                    $_SESSION['category-not-found'] = "<div class='error'>Category not found.</div>";
                    header("location:" . SITEURL . 'admin/update-category.php');
                    exit();
                }
            } else {
                header("location:" . SITEURL . 'admin/manage-category.php');
                exit();
            }
        ?> 

      

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Category Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
            </div>

            <div class="form-group">
                <label for="title">Current Image</label>
                <td>
                <?php
                    if($current_image != ""){
                        ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="Category Image" width="150">
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
                <input type="submit" name="submit" value="Update Category" class="btn-secondary">
            </div>
        </form>

        <?php
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];
                $ext = end(explode('.', $image_name));
                $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];
            
                if (in_array($ext, $allowed_extensions)) {
                    $new_image_name = "Category_".rand(000, 999).'.'.$ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$new_image_name;
            
                    $upload = move_uploaded_file($source_path, $destination_path);
                    if (!$upload) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                        die();
                    }
                } else {
                    $_SESSION['upload'] = "<div class='error'>Invalid File Format.</div>";
                    header('location:'.SITEURL.'admin/update-category.php');
                    die();
                }
            } else {
                $new_image_name = $current_image; // Use the current image if no new image is uploaded
            }
            
        ?>


        <?php
            if (isset($_POST['submit'])) {
                $title = $_POST['title'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
            
                $stmt = $conn->prepare("UPDATE tbl_category SET title = ?, image_name = ?, featured = ?, active = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $title, $new_image_name, $featured, $active, $id);
            
                $result = $stmt->execute();
                if ($result) {
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                    header("location:" . SITEURL . 'admin/manage-category.php');
                } else {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                    header("location:" . SITEURL . 'admin/update-category.php');
                }
            }
            
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>