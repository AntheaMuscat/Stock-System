<?php 

require("config.php"); 

// Check if the request method is POST (form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; //get id from form

    try {
        // Prepare the DELETE statement
        $stmt = $conn->prepare("DELETE FROM stock_items WHERE id = :id");
        $stmt->bindParam(':id', $id); // Bind the ID parameter to the query
        
        // Execute the statement
        $stmt->execute();
        
        //Redirect back to index.php
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
