<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$response = ["success" => false, "cartCount" => 0];

if (isset($_POST['id']) && isset($_POST['size']) && isset($_POST['quantity'])) {
    $id = $_POST['id'];
    $size = $_POST['size'];
    $quantity = max(1, (int)$_POST['quantity']); // prevent 0 or negative qty

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id && $item['size'] == $size) {
                $item['quantity'] = $quantity;
                break;
            }
        }
    }

    // Calculate cart count
    $cartCount = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += $item['quantity'];
        }
    }

    $response = ["success" => true, "cartCount" => $cartCount];
}

header("Content-Type: application/json");
echo json_encode($response);
exit;
