<?php
include "db.php";

// ✅ Protect: only logged-in users
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// ✅ Fetch the latest order(s) for this user
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - MyShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<main>
    <h2 style="text-align:center; margin-top:20px; color:green;">✅ Payment Successful</h2>
    <p style="text-align:center;">Thank you, <?= htmlspecialchars($_SESSION["user_name"]) ?>! Your order has been placed.</p>

    <div class="orders-container">
        <h3>Recent Orders</h3>
        <?php if ($res->num_rows > 0): ?>
            <?php while ($row = $res->fetch_assoc()): ?>
                <div class="order-item">
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" class="order-img">
                    <div class="order-info">
                        <p><strong><?= htmlspecialchars($row['product_name']) ?></strong> (<?= htmlspecialchars($row['size']) ?>)</p>
                        <p>₹<?= number_format($row['price'], 2) ?> × <?= $row['quantity'] ?></p>
                        <p><strong>Total:</strong> ₹<?= number_format($row['price'] * $row['quantity'], 2) ?></p>
                        <p><em>Order Date:</em> <?= $row['order_date'] ?></p>
                        <p><em>Payment ID:</em> <?= $row['razorpay_payment_id'] ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</main>

<?php include "footer.php"; ?>

<style>
.orders-container {
    width: 80%;
    margin: 20px auto;
}
.order-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}
.order-img {
    width: 80px;
    height: auto;
    margin-right: 15px;
    border-radius: 6px;
}
.order-info p {
    margin: 5px 0;
}
</style>

<script src="script.js"></script>
</body>
</html>
