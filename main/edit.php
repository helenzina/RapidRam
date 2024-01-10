<?php
session_start();

$mysqli = require __DIR__ . "/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editBtn"])) {
    // Retrieve form data
    $productId = $_POST['product_id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $capacity = $_POST['capacity'];
    $channel = $_POST['channel'];
    $speed = $_POST['speed'];
    $price = $_POST['price'];
    $photo = $_POST['photo'];

    $query = "UPDATE ram SET brand=?, model=?, capacity=?, channel=?, speed=?, price=?, photo=? WHERE product_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssssssi", $brand, $model, $capacity, $channel, $speed, $price, $photo, $productId);
    
    if ($stmt->execute()) {
        // Success: Redirect or display a success message
        header("Location: admin.php");
    } else {
        // Error: Handle the error as needed
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>
