<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h2 class="text-center">ADD ADMIN</h2>

         <!-- show success message -->
        <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
        ?>


        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="full_name" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Add Admin" class="btn">
            </div>
        </form>
    </div>
</div>
       



<?php include('partials/footer.php');?>

<?php
if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO tbl_admin (full_name, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $username, $password);

    if ($stmt->execute()) {
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
    $stmt->close();
}
?>