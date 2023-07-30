<?php
require_once "db_config.php";

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    $sql = "SELECT * FROM item WHERE id = $item_id";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $item_code = $row['item_code'];
        $item_name = $row['item_name'];
        $item_category = $row['item_category'];
        $item_subcategory = $row['item_subcategory'];
        $quantity = $row['quantity'];
        $unit_price = $row['unit_price'];
    } else {
        // Item not found, redirect back to item.php
        header("Location: item.php");
        exit();
    }
} else {
    // If no item ID provided, redirect back to item.php
    header("Location: item.php");
    exit();
}

$error_messages = array();

if (isset($_POST['updateItem'])) {
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_sub_category'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    // Common empty error message
    if (empty($item_code) || empty($item_name) || empty($item_category) || empty($item_subcategory) || empty($quantity) || empty($unit_price)) {
        $error_messages['common'] = "All fields are required.";
    }

    // Individual field validation errors
    if (empty($item_code)) {
        $error_messages['item_code'] = "Item code is required";
    }
    if (empty($item_name)) {
        $error_messages['item_name'] = "Item name is required";
    }
    if (empty($item_category)) {
        $error_messages['item_category'] = "Item category is required";
    }
    if (empty($item_subcategory)) {
        $error_messages['item_sub_category'] = "Item subcategory is required";
    }
    if (empty($quantity)) {
        $error_messages['quantity'] = "Quantity is required";
    }
    if (empty($unit_price)) {
        $error_messages['unit_price'] = "Unit price is required";
    }

    if (empty($error_messages)) {
        // Perform database update 
        $sql = "UPDATE item SET item_code='$item_code', item_name='$item_name', item_category='$item_category', item_subcategory='$item_subcategory', quantity='$quantity', unit_price='$unit_price' WHERE id = $item_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: item.php");
            exit();
        } else {
            $error_messages['common'] = "Error updating item: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="forms.css">
</head>

<body>

    <div class="main">

        <form style="width: 400px" method="post">
            <h2 style="text-align: center">Edit Item</h2>

            <?php if (isset($error_messages['common'])) { ?>
            <p style="color: red;"><?php echo $error_messages['common']; ?></p>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">Item Code</label>
                <input type="text" name="item_code" class="form-control"
                    value="<?php echo isset($item_code) ? $item_code : ''; ?>">
                <?php if (isset($error_messages['item_code'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['item_code']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Item Name</label>
                <input type="text" name="item_name" class="form-control"
                    value="<?php echo isset($item_name) ? $item_name : ''; ?>">
                <?php if (isset($error_messages['item_name'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['item_name']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Item Category</label>
                <input type="text" name="item_category" class="form-control"
                    value="<?php echo isset($item_category) ? $item_category : ''; ?>">
                <?php if (isset($error_messages['item_category'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['item_category']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Item Subcategory</label>
                <input type="text" name="item_sub_category" class="form-control"
                    value="<?php echo isset($item_subcategory) ? $item_subcategory : ''; ?>">
                <?php if (isset($error_messages['item_sub_category'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['item_sub_category']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="text" name="quantity" class="form-control"
                    value="<?php echo isset($quantity) ? $quantity : ''; ?>">
                <?php if (isset($error_messages['quantity'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['quantity']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Unit Price</label>
                <input type="text" name="unit_price" class="form-control"
                    value="<?php echo isset($unit_price) ? $unit_price : ''; ?>">
                <?php if (isset($error_messages['unit_price'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['unit_price']; ?></div>
                <?php } ?>
            </div>
            <button type="submit" name="updateItem" class="btn btn-primary">Update Item</button>
            <a href="item.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>