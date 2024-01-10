<?php

session_start();
$mysqli = require __DIR__ . "/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteBtn"])) {
    $stmt = $mysqli->prepare("DELETE FROM ram WHERE product_id = ?");
    $stmt->bind_param("i", $_POST['product_id']);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
