<?php
require_once "db_config.php";

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE id = $customer_id";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $first_name = $row['first_name'];
        $middle_name = $row['middle_name'];
        $last_name = $row['last_name'];
        $contact_no = $row['contact_no'];
        $district = $row['district'];
    } else {
        // Customer not found, redirect back to customer.php
        header("Location: customer.php");
        exit();
    }
} else {
    // If no customer ID provided, redirect back to customer.php
    header("Location: customer.php");
    exit();
}

$error_messages = array();

if (isset($_POST['updateCustomer'])) {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district = $_POST['district'];

    // Common empty error message
    if (empty($title) || empty($first_name) || empty($last_name) || empty($contact_no) || empty($district)) {
        $error_messages['common'] = "All fields are required.";
    }

    // Individual field validation errors
    if (empty($title)) {
        $error_messages['title'] = "Title is required";
    }
    if (empty($first_name)) {
        $error_messages['first_name'] = "First name is required";
    }
    if (empty($last_name)) {
        $error_messages['last_name'] = "Last name is required";
    }
     if (empty($middle_name)) {
        $error_messages['middle_name'] = "Middle name is required";
    }
    if (empty($contact_no)) {
        $error_messages['contact_no'] = "Contact number is required";
    }
    if (empty($district)) {
        $error_messages['district'] = "District is required";
    }

    if (empty($error_messages)) {
        
        $sql = "UPDATE customer SET title='$title', first_name='$first_name', middle_name='$middle_name', last_name='$last_name', contact_no='$contact_no', district='$district' WHERE id = $customer_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: customer.php");
            exit();
        } else {
            $error_messages['common'] = "Error updating customer: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="forms.css">
</head>

<body>
    <div class="main">

        <form style="width: 400px" method="post">
            <h2 style="text-align: center">Edit Customer</h2>

            <?php if (isset($error_messages['common'])) { ?>
            <p style="color: red;"><?php echo $error_messages['common']; ?></p>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">Title</label><br>
                <input type="radio" name="title" value="Mr"
                    <?php if (isset($title) && $title == 'Mr') echo 'checked'; ?>>
                <label>Mr</label>
                <input type="radio" name="title" value="Mrs"
                    <?php if (isset($title) && $title == 'Mrs') echo 'checked'; ?>>
                <label>Mrs</label>
                <input type="radio" name="title" value="Miss"
                    <?php if (isset($title) && $title == 'Miss') echo 'checked'; ?>>
                <label>Miss</label>
                <input type="radio" name="title" value="Dr"
                    <?php if (isset($title) && $title == 'Dr') echo 'checked'; ?>>
                <label>Dr</label>
                <?php if (isset($error_messages['title'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['title']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control"
                    value="<?php echo isset($first_name) ? $first_name : ''; ?>">
                <?php if (isset($error_messages['first_name'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['first_name']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" class="form-control"
                    value="<?php echo isset($middle_name) ? $middle_name : ''; ?>">
                <?php if (isset($error_messages['middle_name'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['middle_name']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control"
                    value="<?php echo isset($last_name) ? $last_name : ''; ?>">
                <?php if (isset($error_messages['last_name'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['last_name']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact No</label>
                <input type="text" name="contact_no" class="form-control"
                    value="<?php echo isset($contact_no) ? $contact_no : ''; ?>">
                <?php if (isset($error_messages['contact_no'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['contact_no']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">District</label>
                <input type="text" name="district" class="form-control"
                    value="<?php echo isset($district) ? $district : ''; ?>">
                <?php if (isset($error_messages['district'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['district']; ?></div>
                <?php } ?>
            </div>
            <button type="submit" name="updateCustomer" class="btn btn-primary">Update Customer</button>
            <a href="customer.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>