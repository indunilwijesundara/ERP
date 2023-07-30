<?php
require_once "db_config.php";


    $sql = "SELECT item_name, item_category, item_subcategory, SUM(quantity) AS total_quantity 
        FROM item 
        GROUP BY item_name, item_category, item_subcategory";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $invoices[] = $row;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="listview.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Item Report</h2>
    </div>

    <?php if (count($invoices) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Item category</th>
                <th>Item Sub Category</th>
                <th>Item Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoices as $invoice): ?>
            <tr>
                <td><?php echo $invoice['item_name']; ?></td>
                <td><?php echo $invoice['item_category']; ?></td>
                <td><?php echo $invoice['item_subcategory'] ;?></td>
                <td><?php echo $invoice['total_quantity']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>
    </div>
</body>

</html>