<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Policy - Brandkabappp</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<header style="padding:20px; text-align:center;">
    <h2>Shipping Policy</h2>
</header>

<section id="shipping-policy-section" style="padding:40px; background:#111; color:#ccc;">
    <div class="container" style="max-width:900px; margin:auto;">
        <h2 class="text-3xl font-bold text-center text-white mb-12">Shipping Policy</h2>
        <div class="policy-content" style="line-height:1.8;">

            <p>We are committed to delivering your orders quickly and securely. Please read our shipping policy carefully to understand how your orders will be processed and shipped.</p>

            <h3 class="text-xl font-semibold text-white mb-3">1. Processing Time</h3>
            <p>All orders are processed within <strong>1–3 business days</strong>. Bulk orders may take longer, and we will notify you of the expected timeline after confirmation.</p>

            <h3 class="text-xl font-semibold text-white mb-3">2. Shipping Rates & Delivery</h3>
            <p>Shipping charges are calculated at checkout based on your location and the weight of your order.</p>
            <ul style="margin-left:20px; list-style:disc;">
                <li><strong>Domestic delivery (within India):</strong> 2–5 business days.</li>
                <li><strong>International delivery:</strong> Currently, we are not shipping internationally.</li>
            </ul>

            <h3 class="text-xl font-semibold text-white mb-3">3. Tracking Information</h3>
            <p>Once your order is shipped, a tracking number will be emailed to you. You can track your order on the shipping provider’s website.</p>

        </div>
    </div>
</section>

<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html>
