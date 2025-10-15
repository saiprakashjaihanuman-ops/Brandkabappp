<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$response = ["success" => false, "cartCount" => 0];

if (isset($_POST['id']) && isset($_POST['size'])) {
    $id = $_POST['id'];
    $size = $_POST['size'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $id && $item['size'] == $size) {
                unset($_SESSION['cart'][$index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
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
