<?php
require_once "db_config.php";

$error_messages = array();

if (isset($_POST['addItem'])) {
    $itemcode = $_POST['item_code'];
    $itemname = $_POST['item_name'];
    $itemcategory = $_POST['item_category'];
    $itemsubcategory = $_POST['item_sub_category'];
    $quantity = $_POST['quantity'];
    $unitprice = $_POST['unit_price'];

    // Common empty error message
    if (empty($itemcode) || empty($itemname) || empty($itemcategory) || empty($itemsubcategory) || empty($quantity) || empty($unitprice)) {
        $error_messages['common'] = "All fields are required.";
    }

    // Individual field validation errors
    if (empty($itemcode)) {
        $error_messages['item_code'] = "Item Code is required";
    }

    if (empty($itemname)) {
        $error_messages['item_name'] = "Item Name is required";
    }

    if (empty($itemcategory)) {
        $error_messages['item_category'] = "Item Category is required";
    }

    if (empty($itemsubcategory)) {
        $error_messages['item_sub_category'] = "Item Sub Category is required";
    }

    if (empty($quantity)) {
        $error_messages['quantity'] = "Quantity is required";
    }

    if (empty($unitprice)) {
        $error_messages['unit_price'] = "Unit Price is required";
    }

    if (empty($error_messages)) {
        $sql = "insert into item(item_code,item_category,item_subcategory,item_name,quantity,unit_price) values('$itemcode','$itemcategory','$itemsubcategory','$itemname','$quantity','$unitprice')";
        if ($conn->query($sql) === TRUE) {
            header("Location: item.php");
            alert("Successfully Added");
            exit();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="forms.css">
</head>

<body>
    <div class="main">
        <form style="width:500px" method="post">
            <h2 style="text-align: center">Add Item</h2>
            <?php if (isset($error_messages['common'])) { ?>
            <p style="color: red;"><?php echo $error_messages['common']; ?></p>
            <?php } ?>
            <div class=" mb-3">
                <label class="form-label">Item Code</label>
                <input type="text" name="item_code"
                    class="form-control <?php if (isset($error_messages['item_code'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['item_code']) ? $_POST['item_code'] : ''; ?>">
                <?php if (isset($error_messages['item_code'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['item_code']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Item Name</label>
                <input type="text" name="item_name"
                    class="form-control <?php if (isset($error_messages['item_name'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['item_name']) ? $_POST['item_name'] : ''; ?>">
                <?php if (isset($error_messages['item_name'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['item_name']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Item Category</label>
                <input type="text" name="item_category"
                    class="form-control <?php if (isset($error_messages['item_category'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['item_category']) ? $_POST['item_category'] : ''; ?>">
                <?php if (isset($error_messages['item_category'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['item_category']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Item Sub Category</label>
                <input type="text" name="item_sub_category"
                    class="form-control <?php if (isset($error_messages['item_sub_category'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['item_sub_category']) ? $_POST['item_sub_category'] : ''; ?>">
                <?php if (isset($error_messages['item_sub_category'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['item_sub_category']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="text" name="quantity"
                    class="form-control <?php if (isset($error_messages['quantity'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>">
                <?php if (isset($error_messages['quantity'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['quantity']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Unit Price</label>
                <input type="text" name="unit_price"
                    class="form-control <?php if (isset($error_messages['unit_price'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['unit_price']) ? $_POST['unit_price'] : ''; ?>">
                <?php if (isset($error_messages['unit_price'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['unit_price']; ?></div>
                <?php } ?>
            </div>
            <button type="submit" name="addItem" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>