<?php include('partials/menu.php');?>


        <div class="main-content">
            <div class="wrapper">
                <h2 class="text-center">ADD TABLE</h2>


                    <?php

                    if (isset($_SESSION['add'])) {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    ?><br><br>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="POST">
                                <label for="table_name">Table Name:</label>
                                <input type="text" id="table_name" name="table_name">

                                <label for="table_capacity">Table Capacity:</label>
                                <input type="number" id="table_capacity" name="table_capacity">

                                <label for="table_status">Table Status:</label>
                                    <select name="table_status" required>
                                    <option value="Free">Free</option>
                                    <option value="Occupied">Occupied</option>
                                    <option value="Reserved">Reserved</option>
                                </select>

                                <input type="submit" name="submit" value="Add Table" class="btn">

                            </form>
                        </div>
                    </div>

            </div>
        </div>


<?php
if (isset($_POST['submit'])) {
    $table_name = $_POST['table_name'];
    $table_capacity = $_POST['table_capacity'];
    $table_status = $_POST['table_status'];

    $stmt = $conn->prepare("INSERT INTO tbl_table (table_name, table_capacity, table_status) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("sis", $table_name, $table_capacity, $table_status);
    
    if ($stmt->execute()) {
        $_SESSION['add'] = "<div class='success'>Table Added Successfully</div>";
        header("location:" . SITEURL . 'admin/manage-tables.php');
        exit();
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Table: " . $stmt->error . "</div>";
        header("location:" . SITEURL . 'admin/add-table.php');
        exit();
    }
    $stmt->close();
}
?>
