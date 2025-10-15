<?php
include "db.php";
include "navbar.php";

// ✅ Pagination setup
$limit = 10; // coupons per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// ✅ Count total
$total_res = $conn->query("SELECT COUNT(*) AS total FROM coupons");
$total_row = $total_res->fetch_assoc();
$total_coupons = $total_row['total'];
$total_pages = ceil($total_coupons / $limit);

// ✅ Fetch paginated coupons
$coupons = $conn->query("SELECT * FROM coupons ORDER BY id DESC LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Coupons</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Coupons</h2>
    <a href="add_coupon.php" class="btn btn-success">+ Add Coupon</a>
  </div>

  <table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Code</th>
        <th>Type</th>
        <th>Value</th>
        <th>Usage</th>
        <th>Expiry</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($c = $coupons->fetch_assoc()): ?>
        <tr>
          <td><?= $c["id"] ?></td>
          <td><strong><?= htmlspecialchars($c["code"]) ?></strong></td>
          <td><?= ucfirst($c["discount_type"]) ?></td>
          <td><?= $c["discount_type"] == "percent" ? $c["discount_value"]."%" : "₹".$c["discount_value"] ?></td>
          <td><?= $c["used_count"] ?>/<?= $c["usage_limit"] ?></td>
          <td><?= $c["expiry_date"] ?: "-" ?></td>
          <td>
            <a href="edit_coupon.php?id=<?= $c["id"] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
            <a href="delete_coupon.php?id=<?= $c["id"] ?>" class="btn btn-danger btn-sm"
               onclick="return confirm('Delete this coupon?')">Delete</a>
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
