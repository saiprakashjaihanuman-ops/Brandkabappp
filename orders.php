<?php
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php?redirect=orders.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch orders joined with product_variants and products
$sql = "SELECT o.id, o.product_name, o.price, o.quantity, o.order_date, 
               v.size, p.image
        FROM orders o
        LEFT JOIN product_variants v ON o.variant_id = v.id
        LEFT JOIN products p ON v.product_id = p.id
        WHERE o.user_id = ?
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders - MyShop</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "navbar.php"; ?>

<main>
  <h2 style="text-align:center; margin-top:20px;">My Orders</h2>

  <?php if ($res->num_rows > 0): ?>
    <table class="order-table">
      <thead>
        <tr>
          <th>Image</th>
          <th>Product</th>
          <th>Size</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Order Date</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
          <td><img src="<?= htmlspecialchars($row['image']) ?>" width="60"></td>
          <td><?= htmlspecialchars($row['product_name']) ?></td>
          <td><?= $row['size'] ?></td>
          <td><?= $row['quantity'] ?></td>
          <td>₹<?= number_format($row['price'] * $row['quantity'], 2) ?></td>
          <td><?= date("d M Y, H:i", strtotime($row['order_date'])) ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p style="text-align:center; margin-top:20px;">You have no orders yet.</p>
  <?php endif; ?>
</main>

<?php include "footer.php"; ?>
</body>
</html>
