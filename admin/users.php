<?php
include "db.php";
include "navbar.php";

// ✅ Pagination setup
$limit = 10; // users per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// ✅ Count total users
$total_res = $conn->query("SELECT COUNT(*) AS total FROM users");
$total_row = $total_res->fetch_assoc();
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $limit);

// ✅ Fetch paginated users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Users</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Users</h2>
    <a href="add_user.php" class="btn btn-success">+ Add User</a>
  </div>

  <table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($u = $users->fetch_assoc()): ?>
        <tr>
          <td><?= $u["id"] ?></td>
          <td><?= htmlspecialchars($u["name"]) ?></td>
          <td><?= htmlspecialchars($u["email"]) ?></td>
          <td>
            <a href="edit_user.php?id=<?= $u["id"] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
            <a href="delete_user.php?id=<?= $u["id"] ?>" class="btn btn-danger btn-sm"
               onclick="return confirm('Delete this user?')">Delete</a>
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
