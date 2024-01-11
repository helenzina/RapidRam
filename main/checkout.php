<?php

session_start();

$mysqli = require __DIR__ . "/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkoutBtn"])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $delivery_address = $_POST['delivery_address'];
    $products = $_POST['products'];
    $total = $_POST['total'];

    // Retrieve product quantities from the hidden input field
    $productQuantities = json_decode($_POST['product_ids_and_quantities'], true);

    // Create a string in the format "quantity x product_id, quantity x product_id, ..."
    $formattedProductQuantities = implode(', ', array_map(function ($quantity, $productId) {
        return $quantity . 'x' . $productId;
    }, $productQuantities, array_keys($productQuantities)));

    // Insert data into the database
    $query = "INSERT INTO orders (firstname, lastname, email, tel, delivery_address, products, total) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssssss", $firstname, $lastname, $email, $tel, $delivery_address, $formattedProductQuantities, $total);

    if ($stmt->execute()) {
        // Success: Redirect with a success message
        header("Location: {$_SERVER['HTTP_REFERER']}?success=1");
        exit();
    } else {
        // Error: Handle the error as needed
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
