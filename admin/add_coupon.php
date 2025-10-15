<?php
include "db.php";
include "navbar.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code = $_POST["code"];
    $type = $_POST["discount_type"];
    $value = $_POST["discount_value"];
    $expiry = $_POST["expiry_date"];
    $limit = $_POST["usage_limit"];

    $stmt = $conn->prepare("INSERT INTO coupons (code, discount_type, discount_value, expiry_date, usage_limit) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssdsi", $code, $type, $value, $expiry, $limit);
    $stmt->execute();

    header("Location: coupons.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Coupon</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <h2>Add Coupon</h2>
  <form method="post">
    <input type="text" name="code" placeholder="Coupon Code" class="form-control mb-2" required>
    <select name="discount_type" class="form-control mb-2">
      <option value="flat">Flat</option>
      <option value="percent">Percent</option>
    </select>
    <input type="number" step="0.01" name="discount_value" placeholder="Discount Value" class="form-control mb-2" required>
    <input type="date" name="expiry_date" class="form-control mb-2" required>
    <input type="number" name="usage_limit" placeholder="Usage Limit" class="form-control mb-2" required>
    <button type="submit" class="btn btn-success">Save</button>
  </form>
</div>
</body>
</html>
