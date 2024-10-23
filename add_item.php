<?php
require("config.php");

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Get values from the form
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    try {
        //Prepare INSERT statement
        $stmt = $conn->prepare("INSERT INTO stock_items (name, description, quantity) VALUES (:name, :description, :quantity)");
        //Bind Parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();

        // Redirect to the main page after adding an item
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error adding item: " . $e->getMessage();
    }
}
?>
