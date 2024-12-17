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

        <div class="row">
            <div class="col-md-12">
                <form action="" method="POST">
                    <label for="name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name">

                    <label for="username">User Name:</label>
                    <input type="text" id="username" name="username">

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">

                    <input type="submit" name="submit" value="Add Admin" class="btn">
                    
                </form>
            </div>
        </div>


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

</div>
</div>

<?php include('partials/footer.php'); ?>