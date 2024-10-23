<?php
require("config.php");

// Fetch all stock items from the database
try {
    // Prepare and execute a query to get all stock items
    $stmt = $conn->prepare("SELECT * FROM stock_items");
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetches all result rows and returns the result-set as an associative array
} catch (PDOException $e) {
    echo "Error fetching data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock System</title>
    <link rel="stylesheet" href="styles.css?v=1.3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <h1>Stock Management System</h1>

    <!-- Form for adding a new item -->
    <h2>Add New Item</h2>
    <form class="horizontal-form" action="add_item.php" method="POST">
        <input class="form-control" placeholder="Name" type="text" name="name" required>

        <input class="form-control" placeholder="Description" type="text" name="description">

        <input class="form-control" type="number" placeholder="Quantity" name="quantity" required min="1">

        <button id="add" type="submit" class="btn btn-outline-primary">Add Item</button>
    </form>

    <h2>Current Stock</h2>

    <!-- Display existing items and allow inline editing -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($items as $item) { ?>
    <tr>
        <form action="edit_item.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
            
            <td>
                <label class="id" for="id"><?php echo htmlspecialchars($item['id']); ?></label>
            </td>

            <td>
                <input  class="form-control" id="inputField1" oninput="toggleButton()" type="text" name="name"  value="<?php echo htmlspecialchars($item['name']); ?>" required>
            </td>
            <td>
                <input class="form-control" id="inputField2" oninput="toggleButton()" type="text" name="description"  value="<?php echo htmlspecialchars($item['description']); ?>">
            </td>
            <td>
                <input class="form-control" id="inputField3" oninput="toggleButton()" type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="0">
            </td>
            <td>
                <button id="submitButton"  disabled class="save btn btn-success" type="submit">Save Changes</button>
            </td>
        </form>
        <td>
            <form action="remove_item.php" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                <button type="submit"  class="btn btn-danger">Remove</button>
            </form>
        </td>
    </tr>

    
<?php } ?>

        </table>
</body>

<script>
        function toggleButton() {
            const inputField1 = document.getElementById("inputField1");
            const inputField2 = document.getElementById("inputField2");
            const inputField3 = document.getElementById("inputField3");
            const submitButton = document.getElementById("submitButton");

            // Check if any of the input fields contain non-empty values
            if (inputField1.value.trim() !== "" || inputField2.value.trim() !== "" || inputField3.value.trim() !== "") {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }
</script>


</html>
