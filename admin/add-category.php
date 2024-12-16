<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="text-center">Add Category</h1><br><br>

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
        ?><br><br>


    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" enctype="multipart/form-data">
                
                <fieldset>
                               
                    <label for="name">Category Title:</label>
                    <input type="text" id="title" name="title">
                    
                    <label for="email">Upload Image:</label>
                    <input type="file" id="image" name="image">
                    
                    <label>Featured:</label>
                    <input type="radio" id="featured-yes" value="Yes" name="featured"><label for="Yes" class="light">Yes</label><br>
                    <input type="radio" id="featured-no" value="No" name="featured"><label for="No" class="light">No</label>

                    <label>Active:</label>
                    <input type="radio" id="active-yes" value="Yes" name="active"><label for="Yes" class="light">Yes</label><br>
                    <input type="radio" id="active-no" value="No" name="active"><label for="No" class="light">No</label>
                    
                    </fieldset>
                   
            
                    <input type="submit" name="submit" value="Add Category" class="btn">
                
            </form>
        </div>
    </div>




        

        <?php
       if (isset($_POST['submit'])) {
        $title = trim($_POST['title']);
        $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
        $active = isset($_POST['active']) ? $_POST['active'] : "No";
        $image_name = "";
    
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {


            $image_name = $_FILES['image']['name'];

            // rename image

            $ext = pathinfo($image_name, PATHINFO_EXTENSION);

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
