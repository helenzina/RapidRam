<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['cartItems'])) {
        $_SESSION['cart'] = [];
        foreach ($data['cartItems'] as $item) {
            $_SESSION['cart'][$item['product']] = [
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ];
        }
    }
}
?>

