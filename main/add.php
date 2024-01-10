<?php

session_start();

$mysqli = require __DIR__ . "/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBtn"])) {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $capacity = $_POST['capacity'];
    $channel = $_POST['channel'];
    $speed = $_POST['speed'];
    $price = $_POST['price'];
    $photo = $_POST['photo'];

    // Insert data into the database
    $query = "INSERT INTO ram (brand, model, capacity, channel, speed, price, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssssss", $brand, $model, $capacity, $channel, $speed, $price, $photo);
    
    if ($stmt->execute()) {
        // Success: Redirect or display a success message
        header("Location: admin.php");
        exit();
    } else {
        // Error: Handle the error as needed
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
