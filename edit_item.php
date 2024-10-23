<?php
require("config.php");

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values submitted from the form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    // If the quantity is 0, remove the item
    if ($quantity == 0) {
        try {
            //Prepare the DELETE statement
            $stmt = $conn->prepare("DELETE FROM stock_items WHERE id = :id");
            $stmt->bindParam(':id', $id);//Bind the id parameter
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error removing item: " . $e->getMessage();
        }
    } else {
        // Otherwise, update the item details
        try {
            //Prepare the UPDATE statemnet
            $stmt = $conn->prepare("UPDATE stock_items SET name = :name, description = :description, quantity = :quantity WHERE id = :id");
            //Bind the Para,eters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error updating item: " . $e->getMessage();
        }
    }

    // Redirect to the main page after editing an item
    header("Location: index.php");
    exit();
}
?>
