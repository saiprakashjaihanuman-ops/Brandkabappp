<?php
include "db.php";
include "navbar.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $desc = $_POST["description"];
    $image = $_POST["image"];

    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?,?,?,?)");
    $stmt->bind_param("sdss", $name, $price, $desc, $image);
    $stmt->execute();

    header("Location: products.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
  <h2>Add Product</h2>
  <form method="post">
    <input type="text" name="name" placeholder="Product Name" class="form-control mb-2" required>
    <input type="number" step="0.01" name="price" placeholder="Price" class="form-control mb-2" required>
    <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>
    <input type="text" name="image" placeholder="Image URL" class="form-control mb-2" required>
    <button type="submit" class="btn btn-success">Save</button>
  </form>
</div>
</body>
</html>
