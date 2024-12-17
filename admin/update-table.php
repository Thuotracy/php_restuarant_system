<?php include('partials/menu.php'); ?>

<div class="main-content" managestyle="min-height: 100%;"-tables.php>
    <div class="wrapper">
        <h2 class="text-center">UPDATE TABLE</h2><br><br>

        <?php
        if (isset($_GET['table_name'])) {
            $table_name = $_GET['table_name'];

            // Fetch data using prepared statements
            $stmt = $conn->prepare("SELECT * FROM tbl_table WHERE table_name = ?");
            $stmt->bind_param("s", $table_name);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows == 1) {
                $row = $res->fetch_assoc();
                $table_name = $row['table_name'];
                $table_capacity = $row['table_capacity'];
                $table_status = $row['table_status'];
            } else {
                $_SESSION['update'] = "<div class='error'>Table not found.</div>";
                header("location:" . SITEURL . 'admin/manage-tables.php');
                exit();
            }
        } else {
            $_SESSION['update'] = "<div class='error'>Unauthorized access.</div>";
            header("location:" . SITEURL . 'admin/manage-tables.php');
            exit();
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <form action="" method="POST">
                    <label for="table_name">Table Name:</label>
                    <input type="text" name="table_name" value="<?php echo htmlspecialchars($table_name); ?>" required>

                    <label for="table_capacity">Table Capacity:</label>
                    <input type="number" name="table_capacity" value="<?php echo htmlspecialchars($table_capacity); ?>" required>

                    <label for="table_status">Table Status:</label>
                    <select name="table_status" required>
                        <option value="Free" <?php if (strcasecmp($table_status, "Free") == 0) echo "selected"; ?>>Free</option>
                        <option value="Occupied" <?php if (strcasecmp($table_status, "Occupied") == 0) echo "selected"; ?>>Occupied</option>
                        <option value="Reserved" <?php if (strcasecmp($table_status, "Reserved") == 0) echo "selected"; ?>>Reserved</option>
                    </select>

                    <input type="hidden" name="original_table_name" value="<?php echo htmlspecialchars($table_name); ?>">
                    <input type="submit" name="submit" value="Update Table" class="btn">
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['submit'])) {
            $original_table_name = $_POST['original_table_name'];
            $table_name = $_POST['table_name'];
            $table_capacity = $_POST['table_capacity'];
            $table_status = $_POST['table_status'];

            // Update query using prepared statements
            $stmt = $conn->prepare("UPDATE tbl_table SET table_name = ?, table_capacity = ?, table_status = ? WHERE table_name = ?");
            $stmt->bind_param("siss", $table_name, $table_capacity, $table_status, $original_table_name);

            if ($stmt->execute()) {
                $_SESSION['update'] = "<div class='success'>Table Updated Successfully</div>";
                header("location:" . SITEURL . 'admin/manage-tables.php');
                exit();
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Table</div>";
                header("location:" . SITEURL . 'admin/manage-tables.php');
                exit();
            }
            $stmt->close();
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
