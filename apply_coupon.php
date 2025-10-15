<?php
include "db.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$code = trim($data["code"]);
$user_id = $_SESSION["user_id"] ?? 0;

// ✅ Check coupon validity
$stmt = $conn->prepare("SELECT * FROM coupons WHERE code = ? AND (user_id IS NULL OR user_id = ?) LIMIT 1");
$stmt->bind_param("si", $code, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$coupon = $result->fetch_assoc();

if (!$coupon) {
    echo json_encode(["success" => false, "message" => "Invalid coupon"]);
    exit();
}

// ✅ Check expiry
if ($coupon["expiry_date"] && strtotime($coupon["expiry_date"]) < time()) {
    echo json_encode(["success" => false, "message" => "Coupon expired"]);
    exit();
}

// ✅ Check usage limit
if ($coupon["used_count"] >= $coupon["usage_limit"]) {
    echo json_encode(["success" => false, "message" => "Coupon already used"]);
    exit();
}

// ✅ Calculate discount
$discount = 0;
$type = $coupon["discount_type"]; // e.g., "flat" or "percent"
$value = (float)$coupon["discount_value"];

if ($type === "flat") {
    $discount = $value; // fixed amount
} elseif ($type === "percent") {
    // ⚡ percent will be applied in checkout.js (since we need total amount)
    $discount = $value; 
}

// ✅ Store coupon in session
$_SESSION["applied_coupon"] = [
    "code"     => $coupon["code"],
    "type"     => $type,
    "value"    => $value,
    "discount" => $discount
];

// ✅ Return response
echo json_encode([
    "success"  => true,
    "message"  => "Coupon applied successfully!",
    "type"     => $type,
    "value"    => $value,
    "discount" => $discount
]);
?>
