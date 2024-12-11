<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1><br><br>

        <!-- Show success message -->
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Category Title</label>
                <input type="text" id="title" name="title" placeholder="Category Title" required>
            </div>

            <div class="form-group">
                <label for="title">Upload Image</label>
                <input type="file" id="image" name="image">
            </div>

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
                <input type="submit" name="submit" value="Add Category" class="btn-secondary">
            </div>
        </form>

        <?php
       if (isset($_POST['submit'])) {
        $title = trim($_POST['title']);
        $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
        $active = isset($_POST['active']) ? $_POST['active'] : "No";
        $image_name = "";
    
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {


            $image_name = $_FILES['image']['name'];

            // rename image

            $ext = end(explode('.', $image_name));

            $image_name  = "Food_Category_".rand(000, 999).'.'.$ext; 

            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/category/" . $image_name;
    
            if (move_uploaded_file($source_path, $destination_path)) {
                echo "File uploaded successfully.";
            } else {
                $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                header("location:" . SITEURL . 'admin/add-category.php');
                exit;
            }
        }
    
        if ($conn && $conn->connect_error == null) {
            $stmt = $conn->prepare("INSERT INTO tbl_category (title, image_name, featured, active) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $image_name, $featured, $active);
    
            if ($stmt->execute()) {
                $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                header("location:" . SITEURL . 'admin/manage-category.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Category: " . $stmt->error . "</div>";
                header("location:" . SITEURL . 'admin/add-category.php');
            }
            $stmt->close();
        } else {
            $_SESSION['add'] = "<div class='error'>Database Connection Failed</div>";
            header("location:" . SITEURL . 'admin/add-category.php');
        }
    }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
