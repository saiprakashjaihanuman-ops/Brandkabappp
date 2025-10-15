<?php
include "db.php";
header("Content-Type: application/json");

// ✅ Only logged-in users
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

// ✅ Get amount from checkout.php
$data = json_decode(file_get_contents("php://input"), true);
$amount = isset($data["amount"]) ? intval($data["amount"]) : 0;

if ($amount <= 0) {
    echo json_encode(["error" => "Invalid amount"]);
    exit();
}

// ✅ Razorpay Order API endpoint
$url = "https://api.razorpay.com/v1/orders";

// ✅ Payload
$fields = [
    "amount" => $amount,     // amount in paise
    "currency" => "INR",
    "receipt" => "rcpt_" . time(),
    "payment_capture" => 1   // auto capture
];

// ✅ Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, RAZORPAY_KEY_ID . ":" . RAZORPAY_KEY_SECRET);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// ✅ Execute
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => "cURL error: " . curl_error($ch)]);
    curl_close($ch);
    exit();
}

curl_close($ch);

// ✅ Output Razorpay Order JSON (contains `id`, `amount`, etc.)
echo $response;
