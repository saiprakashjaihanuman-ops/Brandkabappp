<?php
include "db.php";
include "navbar.php";

// ✅ Pagination settings
$limit = 5; // number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// ✅ Count total products
$result = $conn->query("SELECT COUNT(*) AS total FROM products");
$row = $result->fetch_assoc();
$total_products = $row['total'];
$total_pages = ceil($total_products / $limit);

// ✅ Fetch products for current page
$products = $conn->query("SELECT * FROM products LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Products</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center">
    <h2>Products</h2>
    <a href="add_product.php" class="btn btn-success">+ Add Product</a>
  </div>

  <table class="table table-bordered mt-3">
    <tr>
      <th>ID</th><th>Name</th><th>Price</th><th>Image</th><th>Actions</th>
    </tr>
    <?php while($p = $products->fetch_assoc()): ?>
      <tr>
        <td><?= $p["id"] ?></td>
        <td><?= $p["name"] ?></td>
        <td>₹<?= $p["price"] ?></td>
        <td><img src="../<?= $p["image"] ?>" width="60"></td>
        <td>
          <a href="edit_product.php?id=<?= $p["id"] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete_product.php?id=<?= $p["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

  <!-- ✅ Pagination Links -->
  <nav>
    <ul class="pagination justify-content-center">
      <?php if ($page > 1): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page-1 ?>">Previous</a></li>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <?php if ($page < $total_pages): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page+1 ?>">Next</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</div>
</body>
</html>
