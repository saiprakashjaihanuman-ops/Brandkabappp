<?php
include "db.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$product_id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found!";
    exit();
}

$product = $result->fetch_assoc();

// Fetch available sizes from product_variants
$size_sql = "SELECT size, stock FROM product_variants WHERE product_id = ?";
$size_stmt = $conn->prepare($size_sql);
$size_stmt->bind_param("i", $product_id);
$size_stmt->execute();
$size_result = $size_stmt->get_result();

$sizes = [];
while ($row = $size_result->fetch_assoc()) {
    $sizes[$row['size']] = $row['stock'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - MyShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .size-options {
            margin: 15px 0;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .size-box {
            position: relative;
        }
        .size-box input {
            display: none;
        }
        .size-box label {
            display: inline-block;
            padding: 10px 16px;
            border: 2px solid #fff;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            color: #fff;
            transition: 0.3s;
            user-select: none;
        }
        .size-box input:checked + label {
            background: #fff;
            color: #000;
        }
        .size-box label:hover {
            background: #000;
        }
        .size-box label.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #333;
        }
    </style>
</head>
<body>

<?php include "navbar.php"; ?>

<main class="product-detail">
    <div class="detail-container">
        <div class="detail-image">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="detail-info">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p class="detail-price">₹<?= number_format($product['price'], 2) ?></p>
            <p class="detail-description"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            
            <form method="post" action="add_to_cart.php">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <!-- Size Options -->
                <div class="size-options">
                    <?php foreach (['S','M','L','XL','XXL'] as $size): ?>
                        <div class="size-box">
                            <input type="radio" 
                                   id="size<?= $size ?>" 
                                   name="size" 
                                   value="<?= $size ?>" 
                                   <?= (isset($sizes[$size]) && $sizes[$size] > 0) ? '' : 'disabled' ?>>
                            <label for="size<?= $size ?>" 
                                   class="<?= (isset($sizes[$size]) && $sizes[$size] > 0) ? '' : 'disabled' ?>">
                                <?= $size ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Quantity Selector -->
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" class="qty-input">

                <button type="submit" class="buy-btn">Add to Cart</button>
            </form>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>
<script src="script.js"></script>
</body>
</html>
