<?php
session_start();

error_log(print_r($_SESSION, true)); // Check session content in error log


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data && isset($data['sessionId'], $data['cartItems'])) {
        if (session_id() === $data['sessionId']) {
            // Update the cart array in the session
            $_SESSION['cart'] = $data['cartItems'];
            echo json_encode(['status' => 'success']);
            exit();
        }
    }
}

echo json_encode(['status' => 'error']);
