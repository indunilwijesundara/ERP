<?php
require_once "db_config.php";

$items = 'select * from item';

// Initialize the search term variable
$searchTerm = '';

// Check if the search form has been submitted
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
    // Add the search condition to the SQL query
    $items .= " WHERE item_code LIKE '%$searchTerm%' OR item_category LIKE '%$searchTerm%' OR item_subcategory LIKE '%$searchTerm%' OR item_name LIKE '%$searchTerm%' OR quantity LIKE '%$searchTerm%' OR unit_price LIKE '%$searchTerm%'";
}

$result = $conn->query($items);

if (isset($_POST['deleteItem'])) {
    $item_id = $_POST['item_id'];
    $sql = "DELETE FROM item WHERE id = $item_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: item.php");
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
    <title>Item List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="listview.css">
</head>

<body>
    <div class="ListView" style="max-width: 1000px">
        <h2 style="text-align: center">Item List</h2>
        <div class="TableHeaderLine">
            <!-- Search form -->
            <form method="post">
                <label for="searchTerm">Search:</label>
                <input class="form-control" type="text" name="searchTerm" id="searchTerm"
                    value="<?php echo $searchTerm; ?>">
                <button type="submit" name="search" class="btn btn-primary">Search</button>
            </form>
            <a href="additem.php" class="btn btn-success">Add New Item</a>
        </div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Item code</th>
                    <th scope="col">Item Category</th>
                    <th scope="col">Item Subcategory</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $item_id = $row["id"];
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["item_code"] . "</td>";
                    echo "<td>" . $row["item_category"] . "</td>";
                    echo "<td>" . $row["item_subcategory"] . "</td>";
                    echo "<td>" . $row["item_name"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    echo "<td>" . $row["unit_price"] . "</td>";
                    echo "<td>";
                    echo "<form method='post' style='display: inline-block;'>";
                    echo "<button type='submit' name='deleteItem' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</button>";
                    echo "<input type='hidden' name='item_id' value='" . $item_id . "'>";
                    echo "</form>";
                    echo "<a href='edititem.php?id=" . $item_id . "' class='btn btn-primary'>Update</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No items found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</body>

</html>