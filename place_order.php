<?php
session_start();
include "db.php";

header("Content-Type: application/json");

// ✅ Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// ✅ Validate required fields
if (
    empty($data["razorpay_payment_id"]) ||
    empty($data["razorpay_signature"]) ||
    empty($data["razorpay_order_id"])
) {
    echo json_encode(["success" => false, "message" => "Payment details missing"]);
    exit;
}

$payment_id = $data["razorpay_payment_id"];
$order_id   = $data["razorpay_order_id"];
$signature  = $data["razorpay_signature"];
$discount   = isset($data["discount"]) ? (float)$data["discount"] : 0;

// ✅ Customer Info
$customer_name    = $data["customer_name"] ?? "";
$customer_mobile  = $data["customer_mobile"] ?? "";
$customer_address = $data["customer_address"] ?? "";

// ✅ Verify Razorpay signature
$generated_signature = hash_hmac("sha256", $order_id . "|" . $payment_id, RAZORPAY_KEY_SECRET);
if ($generated_signature !== $signature) {
    echo json_encode(["success" => false, "message" => "Payment verification failed"]);
    exit;
}

$user_id = $_SESSION["user_id"];

// ✅ Save each cart item as an order
if (!empty($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $item) {
        $sql = "INSERT INTO orders 
        (user_id, product_name, price, quantity, variant_id, size, image, razorpay_payment_id, discount, customer_name, customer_mobile, customer_address) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "isdiisssdsss",   // 👈 FIXED here
    $user_id,               // i
    $item['name'],          // s
    $item['price'],         // d
    $item['quantity'],      // i
    $item['id'],            // i
    $item['size'],          // s
    $item['image'],         // s
    $payment_id,            // s ✅ string not double
    $discount,              // d
    $customer_name,         // s
    $customer_mobile,       // s
    $customer_address       // s
);
$stmt->execute();


        // ✅ Decrease stock for this variant
        $updateStock = $conn->prepare("UPDATE product_variants SET stock = stock - ? WHERE id = ?");
        $updateStock->bind_param("ii", $item['quantity'], $item['id']);
        $updateStock->execute();
    }

    // ✅ Mark coupon as used
    if (isset($_SESSION["applied_coupon"])) {
        $code = $_SESSION["applied_coupon"]["code"];
        $updateCoupon = $conn->prepare("UPDATE coupons SET used_count = used_count + 1 WHERE code = ?");
        $updateCoupon->bind_param("s", $code);
        $updateCoupon->execute();
        unset($_SESSION["applied_coupon"]);
    }

    // ✅ Clear cart
    unset($_SESSION["cart"]);

    echo json_encode(["success" => true, "redirect" => "success.php"]);
    exit;
}

echo json_encode(["success" => false, "message" => "Cart is empty"]);
exit;
