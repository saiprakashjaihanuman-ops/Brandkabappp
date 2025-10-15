<?php
include "db.php";
include "navbar.php";

$id = $_GET["id"];
$coupon = $conn->query("SELECT * FROM coupons WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code = $_POST["code"];
    $type = $_POST["discount_type"];
    $value = $_POST["discount_value"];
    $expiry = $_POST["expiry_date"];
    $limit = $_POST["usage_limit"];
    $used = $_POST["used_count"];

    $stmt = $conn->prepare("UPDATE coupons SET code=?, discount_type=?, discount_value=?, expiry_date=?, usage_limit=?, used_count=? WHERE id=?");
    $stmt->bind_param("ssdsiii", $code, $type, $value, $expiry, $limit, $used, $id);
    $stmt->execute();

    header("Location: coupons.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Coupon</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <h2>Edit Coupon</h2>
  <form method="post">
    <input type="text" name="code" value="<?= $coupon["code"] ?>" class="form-control mb-2" required>
    <select name="discount_type" class="form-control mb-2">
      <option value="flat" <?= $coupon["discount_type"]=="flat"?"selected":"" ?>>Flat</option>
      <option value="percent" <?= $coupon["discount_type"]=="percent"?"selected":"" ?>>Percent</option>
    </select>
    <input type="number" step="0.01" name="discount_value" value="<?= $coupon["discount_value"] ?>" class="form-control mb-2" required>
    <input type="date" name="expiry_date" value="<?= $coupon["expiry_date"] ?>" class="form-control mb-2" required>
    <input type="number" name="usage_limit" value="<?= $coupon["usage_limit"] ?>" class="form-control mb-2" required>
    <input type="number" name="used_count" value="<?= $coupon["used_count"] ?>" class="form-control mb-2" required>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
</body>
</html>
