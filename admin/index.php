<?php
include "db.php";
include "navbar.php";

// Total Products
$total_products = $conn->query("SELECT COUNT(*) AS c FROM products")->fetch_assoc()["c"];

// Total Orders
$total_orders = $conn->query("SELECT COUNT(*) AS c FROM orders")->fetch_assoc()["c"];

// Total Sales
$total_sales = $conn->query("SELECT SUM(price * quantity - discount) AS total FROM orders")->fetch_assoc()["total"];

// Stock summary
$stock_summary = $conn->query("
  SELECT p.name, v.size, v.stock, p.image 
  FROM product_variants v 
  JOIN products p ON v.product_id = p.id
  ORDER BY p.name, v.size
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <h2>Admin Dashboard</h2>

  <div class="row text-center my-4">
    <div class="col-md-4">
      <div class="card p-3 shadow">
        <h4>📦 Total Products</h4>
        <p class="display-6"><?= $total_products ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 shadow">
        <h4>🛒 Total Orders</h4>
        <p class="display-6"><?= $total_orders ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 shadow">
        <h4>💰 Total Sales</h4>
        <p class="display-6">₹<?= number_format($total_sales, 2) ?></p>
      </div>
    </div>
  </div>

  <h3 class="mt-4">📊 Stock Summary</h3>
  <table class="table table-bordered">
    <tr>
      <th>Product</th><th>Size</th><th>Stock</th><th>Image</th>
    </tr>
    <?php while($row = $stock_summary->fetch_assoc()): ?>
      <tr>
        <td><?= $row["name"] ?></td>
        <td><?= $row["size"] ?></td>
        <td><?= $row["stock"] ?></td>
        <td><img src="../<?= $row["image"] ?>" width="60"></td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
