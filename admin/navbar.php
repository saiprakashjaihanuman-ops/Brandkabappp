<?php if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
} ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
  <a class="navbar-brand" href="index.php">Admin Panel</a>
  <ul class="navbar-nav ms-auto">
    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
    <li class="nav-item"><a class="nav-link" href="coupons.php">Coupons</a></li>
    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
  </ul>
</nav>
