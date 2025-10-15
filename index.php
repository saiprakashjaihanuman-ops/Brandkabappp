<?php 
include "db.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>brandkabappp - simple & comfort</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<header style="padding:20px; text-align:center;">
    <?php if (isset($_SESSION["user_name"])): ?>
        <h2>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</h2>
    <?php else: ?>
        <h2>Welcome to Brandkabappp</h2>
    <?php endif; ?>
</header>

<section class="products">
    <?php
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()): ?>
        <div class="product">
            <!-- Product Image & Name -->
            <a href="product.php?id=<?= $row['id'] ?>">
                <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
            </a>
            <p>$<?= number_format($row['price'], 2) ?></p>

            <!-- View Details Button -->
            <a href="product.php?id=<?= $row['id'] ?>" class="view-btn">View Details</a>
        </div>
    <?php endwhile; ?>
</section>

<?php include "footer.php"; ?>


<script src="script.js"></script>
</body>
</html>
