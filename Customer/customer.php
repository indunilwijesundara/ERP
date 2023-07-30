<?php
require_once "db_config.php";

$customers = 'SELECT * FROM customer';

// Initialize the search term variable
$searchTerm = '';

// Check if the search form has been submitted
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
 
    $customers .= " WHERE title LIKE '%$searchTerm%' OR first_name LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%' OR contact_no LIKE '%$searchTerm%' OR district LIKE '%$searchTerm%'";
}

$result = $conn->query($customers);

if (isset($_POST['deleteCustomer'])) {
    $customer_id = $_POST['customer_id'];
    $sql = "DELETE FROM customer WHERE id = $customer_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: customer.php");
        exit();
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="listview.css">
</head>

<body>
    <div class="ListView" style="max-width: 800px">
        <h2 style="text-align: center">Customer List</h2>
        <div class="TableHeaderLine">
            <!-- Search form -->
            <form method="post">
                <label for="searchTerm">Search:</label>
                <input class="form-control" type="text" name="searchTerm" id="searchTerm"
                    value="<?php echo $searchTerm; ?>">
                <button type="submit" name="search" class="btn btn-primary">Search</button>
            </form>
            <a href="addcustomer.php" class="btn btn-success">Add New Customer</a>
        </div>
        <table class="table">

            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Middle Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Contact No</th>
                    <th scope="col">District</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $customer_id = $row["id"];
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["middle_name"] . "</td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "<td>" . $row["contact_no"] . "</td>";
                        echo "<td>" . $row["district"] . "</td>";
                        echo "<td>";
                        echo "<form method='post' style='display: inline-block;'>";
                        echo "<button type='submit' name='deleteCustomer' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this customer?');\">Delete</button>";
                        echo "<input type='hidden' name='customer_id' value='" . $customer_id . "'>";
                        echo "</form>";
                        echo "<a href='editcustomer.php?id=" . $customer_id . "' class='btn btn-primary'>Update</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No customers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>