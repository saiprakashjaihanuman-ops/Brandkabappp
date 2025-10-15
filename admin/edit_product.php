<?php
include "db.php";
include "navbar.php";

$id = $_GET["id"];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $desc = $_POST["description"];
    $image = $_POST["image"];

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sdssi", $name, $price, $desc, $image, $id);
    $stmt->execute();

    header("Location: products.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <h2>Edit Product</h2>
  <form method="post">
    <input type="text" name="name" value="<?= $product["name"] ?>" class="form-control mb-2" required>
    <input type="number" step="0.01" name="price" value="<?= $product["price"] ?>" class="form-control mb-2" required>
    <textarea name="description" class="form-control mb-2"><?= $product["description"] ?></textarea>
    <input type="text" name="image" value="<?= $product["image"] ?>" class="form-control mb-2" required>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
</body>
</html>
