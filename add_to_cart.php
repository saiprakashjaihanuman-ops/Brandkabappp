<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$response = ["success" => false, "cartCount" => 0];

if (isset($_POST['product_id'], $_POST['size'], $_POST['quantity'])) {
    include "db.php";

    $product_id = intval($_POST['product_id']);
    $size = $_POST['size'];
    $quantity = max(1, intval($_POST['quantity']));

    // Fetch product details
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $item = [
            "id" => $row['id'],
            "name" => $row['name'],
            "price" => $row['price'],
            "image" => $row['image'],
            "size" => $size,
            "quantity" => $quantity
        ];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] == $item['id'] && $cartItem['size'] == $item['size']) {
                // Already in cart → increase quantity
                $cartItem['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            // Add as new item
            $_SESSION['cart'][] = $item;
        }

        // Count total items in cart
        $cartCount = 0;
        foreach ($_SESSION['cart'] as $c) {
            $cartCount += $c['quantity'];
        }

        $response = [
            "success" => true,
            "cartCount" => $cartCount,
            "item" => $item
        ];
    }
}

header("Content-Type: application/json");
echo json_encode($response);
exit;
