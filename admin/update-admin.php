<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2 class="text-center">UPDATE ADMIN</h2><br><br>

        <?php
        // Fetch admin data to display in the form
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Fetch data using prepared statements
            $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows == 1) {
                $row = $res->fetch_assoc();
                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                $_SESSION['update'] = "<div class='error'>Admin not found.</div>";
                header("location:" . SITEURL . 'admin/manage-admin.php');
                exit();
            }
        } else {
            $_SESSION['update'] = "<div class='error'>Unauthorized access.</div>";
            header("location:" . SITEURL . 'admin/manage-admin.php');
            exit();
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
            </div>
            <div class="form-group">
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Update Admin" class="btn">
            </div>
        </form>
    </div>
</div>

<?php
// Process form submission
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    // Update query using prepared statements
    $stmt = $conn->prepare("UPDATE tbl_admin SET full_name = ?, username = ? WHERE id = ?");
    $stmt->bind_param("ssi", $full_name, $username, $id);

    if ($stmt->execute()) {
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Admin</div>";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
    $stmt->close();
}
?>

<?php include('partials/footer.php'); ?>
