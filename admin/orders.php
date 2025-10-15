<?php
include "db.php";
include "navbar.php";

// ✅ Pagination setup
$limit = 10; // number of orders per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// ✅ Get total orders count
$total_res = $conn->query("SELECT COUNT(*) AS total FROM orders");
$total_row = $total_res->fetch_assoc();
$total_orders = $total_row['total'];
$total_pages = ceil($total_orders / $limit);

// ✅ Fetch paginated orders
$orders = $conn->query("
  SELECT o.id, o.product_name, o.price, o.quantity, o.size, o.image, 
         o.razorpay_payment_id, o.razorpay_order_id, o.discount, 
         o.customer_name, o.customer_mobile, o.customer_address, o.status,
         u.name AS user_name
  FROM orders o
  JOIN users u ON o.user_id = u.id
  ORDER BY o.id DESC
  LIMIT $limit OFFSET $offset
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Orders</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <h2>Orders</h2>
  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Customer</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Size</th>
        <th>Image</th>
        <th>Payment ID</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while($o = $orders->fetch_assoc()): ?>
        <tr>
          <td><?= $o["id"] ?></td>
          <td><?= $o["user_name"] ?></td>
          <td>
            <strong><?= $o["customer_name"] ?></strong><br>
            <?= $o["customer_mobile"] ?><br>
            <small><?= $o["customer_address"] ?></small>
          </td>
          <td><?= $o["product_name"] ?></td>
          <td><?= $o["quantity"] ?></td>
          <td>₹<?= number_format($o["price"], 2) ?></td>
          <td><?= $o["discount"] > 0 ? "₹".number_format($o["discount"],2) : "-" ?></td>
          <td><?= $o["size"] ?></td>
          <td><img src="../<?= $o["image"] ?>" width="60"></td>
          <td><?= $o["razorpay_payment_id"] ?></td>
          <td>
            <form method="post" action="update_order_status.php" class="d-flex">
              <input type="hidden" name="id" value="<?= $o['id'] ?>">
              <select name="status" class="form-select form-select-sm me-2">
                <option value="Pending"   <?= $o['status']=="Pending"?"selected":"" ?>>Pending</option>
                <option value="Processing"<?= $o['status']=="Processing"?"selected":"" ?>>Processing</option>
                <option value="Shipped"   <?= $o['status']=="Shipped"?"selected":"" ?>>Shipped</option>
                <option value="Delivered" <?= $o['status']=="Delivered"?"selected":"" ?>>Delivered</option>
                <option value="Cancelled" <?= $o['status']=="Cancelled"?"selected":"" ?>>Cancelled</option>
              </select>
              <button type="submit" class="btn btn-sm btn-primary">Update</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- ✅ Pagination -->
  <nav>
    <ul class="pagination justify-content-center">
      <?php if($page > 1): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page-1 ?>">Previous</a></li>
      <?php endif; ?>

      <?php for($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <?php if($page < $total_pages): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page+1 ?>">Next</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</div>
</body>
</html>
