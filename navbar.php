<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Calculate cart count (sum of quantities)
$cartCount = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $c) {
        $cartCount += $c['quantity'];
    }
}
?>
<nav>
    <div class="logo">BRANDKABAPPP</div>
    <ul id="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Products</a></li>
        <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>

    <div class="icons">
        <!-- Cart Icon with Count -->
        <a href="javascript:void(0);" id="cartIcon" class="cart-wrapper">
            <i class="fas fa-shopping-cart" style="color:#fff"></i>
            <span id="cartCount"><?= $cartCount ?></span>
        </a>

        <!-- User Dropdown -->
        <?php if (isset($_SESSION["user_id"])): ?>
            <div class="user-dropdown">
                <i class="fas fa-user" id="userIcon"></i>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="profile.php">Profile</a>
                    <a href="orders.php">Orders</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php"><i class="fas fa-user"></i></a>
        <?php endif; ?>

        <!-- Hamburger Menu -->
        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>

<!-- ✅ Side Cart Drawer -->
<div id="sideCart" class="side-cart">
    <div class="cart-header">
        <h3>Your Cart</h3>
        <button id="closeCart">&times;</button>
    </div>
    <div id="cartItems">
    <?php if (!empty($_SESSION['cart'])): ?>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <!-- ✅ Use data-id and data-size here -->
            <div class="cart-item" data-id="<?= $item['id'] ?>" data-size="<?= $item['size'] ?>">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="">
                <div class="cart-info">
                    <p><?= htmlspecialchars($item['name']) ?> (<?= $item['size'] ?>)</p>
                    <p>₹<?= number_format($item['price'], 2) ?></p>
                    <div class="cart-controls">
                        <input type="number" value="<?= $item['quantity'] ?>" min="1" class="cart-qty">
                        <button class="delete-item">&times;</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Your cart is empty</p>
    <?php endif; ?>
</div>

    <div class="cart-footer">
    <p id="cartTotal">
        <?php
        $total = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $i) {
                $total += $i['price'] * $i['quantity'];
            }
        }
        echo "Total: ₹" . number_format($total, 2);
        ?>
    </p>

    <?php if (isset($_SESSION["user_id"])): ?>
        <!-- User logged in → go to checkout -->
        <a href="checkout.php" class="checkout-btn">Checkout</a>
    <?php else: ?>
        <!-- Not logged in → send to login with redirect -->
        <a href="login.php?redirect=checkout.php" class="checkout-btn">Checkout</a>
    <?php endif; ?>
</div>

</div>
