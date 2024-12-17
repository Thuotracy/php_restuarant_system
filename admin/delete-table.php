<?php 
    include('../config/constant.php');

    // Ensure `table_name` is properly sanitized and escaped
    if (isset($_GET['table_name'])) {
        $table_name = $_GET['table_name'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM tbl_table WHERE table_name = ?");
        $stmt->bind_param("s", $table_name);

        if ($stmt->execute()) {
            $_SESSION['delete'] = "<div class='success'>Table Deleted Successfully</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Table. Try Again Later.</div>";
        }

        $stmt->close();
    } else {
        $_SESSION['delete'] = "<div class='error'>Invalid Request. Table Name is Missing.</div>";
    }

    header('location:' . SITEURL . 'admin/manage-tables.php');
?>
