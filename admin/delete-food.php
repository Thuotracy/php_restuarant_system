<?php
    
    include('../config/constant.php');


    // check whether id and image_name is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name'])){
        
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // remove the physical image

        if($image_name != ""){
            $path = "../images/category/".$image_name;

            $remove = unlink($path);

            if($remove==false){
                // session message
                $_SESSION['remove-img'] = "<div class='error'>Failed to Delete Food Image</div>";
                header("location:" . SITEURL . 'admin/manage-food.php');

                // stop process
                die();
            }
        }

        // delete from db
        $sql = "DELETE FROM tbl_food WHERE id=$id"; 

        $res = mysqli_query($conn, $sql);

        // check whether data is deleted from db or not

        if($res==TRUE){
            $_SESSION['delete-food'] = "<div class='success'>Deleted Food Successfully</div>";
            header("location:" . SITEURL . 'admin/manage-food.php');
        }
        else{
            $_SESSION['remove-food'] = "<div class='error'>Failed to Delete Food</div>";
            header("location:" . SITEURL . 'admin/manage-food.php');
        }

    }
    else{
        // $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
        header("location:" . SITEURL . 'admin/manage-food.php');
    }
?>