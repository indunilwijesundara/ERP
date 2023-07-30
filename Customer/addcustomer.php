<?php
require_once "db_config.php";

$error_messages = array();

if (isset($_POST['addcustomer'])) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $firstname = $_POST['first_name'];
    $middlename = $_POST['middle_name'];
    $lastname = $_POST['last_name'];
    $contactno = $_POST['contact_no'];
    $district = $_POST['district'];

    // Common empty error message
    if (empty($title) || empty($firstname) || empty($lastname) || empty($contactno) || empty($district)) {
        $error_messages['common'] = "All fields are required.";
    }

    // Individual field validation errors
    if (empty($title)) {
        $error_messages['title'] = "Title is required";
    }

    if (empty($firstname)) {
        $error_messages['first_name'] = "First Name is required";
    }
    if (empty($middlename)) {
        $error_messages['middle_name'] = "Middle Name is required";
    }
    if (empty($lastname)) {
        $error_messages['last_name'] = "Last Name is required";
    }

    if (empty($contactno)) {
        $error_messages['contact_no'] = "Contact No is required";
    } elseif (!preg_match('/^\d{10}$/', $contactno)) {
        $error_messages['contact_no'] = "Contact number should contain exactly 10 digits";
    }

    if (empty($district)) {
        $error_messages['district'] = "District is required";
    }

    if (empty($error_messages)) {
        $sql = "insert into customer(title,first_name,middle_name,last_name,contact_no,district) values('$title','$firstname','$middlename','$lastname','$contactno','$district')";
        if ($conn->query($sql) === TRUE) {
            header("Location: customer.php");
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
    <title>Add Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="forms.css">
</head>

<body>
    <div class="main">
        <form style="width:500px" method="post">
            <h2 style="text-align: center">Add Customer</h2>
            <?php if (isset($error_messages['common'])) { ?>
            <p style="color: red;"><?php echo $error_messages['common']; ?></p>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">Title</label><br>
                <input type="radio" name="title" value="Mr"
                    <?php if (isset($_POST['title']) && $_POST['title'] == 'Mr') echo 'checked'; ?>>
                <label>Mr</label>
                <input type="radio" name="title" value="Mrs"
                    <?php if (isset($_POST['title']) && $_POST['title'] == 'Mrs') echo 'checked'; ?>>
                <label>Mrs</label>
                <input type="radio" name="title" value="Miss"
                    <?php if (isset($_POST['title']) && $_POST['title'] == 'Miss') echo 'checked'; ?>>
                <label>Miss</label>
                <input type="radio" name="title" value="Dr"
                    <?php if (isset($_POST['title']) && $_POST['title'] == 'Dr') echo 'checked'; ?>>
                <label>Dr</label>
                <?php if (isset($error_messages['title'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['title']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name"
                    class="form-control <?php if (isset($error_messages['first_name'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>">
                <?php if (isset($error_messages['first_name'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['first_name']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name"
                    class="form-control <?php if (isset($error_messages['middle_name'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['middle_name']) ? $_POST['middle_name'] : ''; ?>">
                <?php if (isset($error_messages['middle_name'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['middle_name']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name"
                    class="form-control <?php if (isset($error_messages['last_name'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>">
                <?php if (isset($error_messages['last_name'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['last_name']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact No</label>
                <input type="text" name="contact_no"
                    class="form-control <?php if (isset($error_messages['contact_no'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['contact_no']) ? $_POST['contact_no'] : ''; ?>">
                <?php if (isset($error_messages['contact_no'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['contact_no']; ?></div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">District</label>
                <input type="text" name="district"
                    class="form-control <?php if (isset($error_messages['district'])) echo 'is-invalid'; ?>"
                    value="<?php echo isset($_POST['district']) ? $_POST['district'] : ''; ?>">
                <?php if (isset($error_messages['district'])) { ?>
                <div class="invalid-feedback"><?php echo $error_messages['district']; ?></div>
                <?php } ?>
            </div>

            <button type="submit" name="addcustomer" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>