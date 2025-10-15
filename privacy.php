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
    <title>Privacy Policy - Brandkabappp</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<header style="padding:20px; text-align:center;">
    <h2>Privacy Policy</h2>
</header>

<section id="privacy-policy-section" class="py-16 sm:py-24 bg-gray-900 border-t border-gray-800" style="padding:40px; background:#111; color:#ccc;">
    <div class="container" style="max-width:900px; margin:auto;">
        <h2 class="text-3xl font-bold text-center text-white mb-12">Privacy Policy</h2>
        <div class="policy-content" style="line-height:1.8;">

            <h3 class="text-xl font-semibold text-white mb-3">1. Information We Collect</h3>
            <p>We collect personal information such as name, email, phone number, address, and payment details when you place an order or contact us. We also collect non-personal data like IP address, browser type, and site usage.</p>

            <h3 class="text-xl font-semibold text-white mb-3">2. How We Use Your Information</h3>
            <ul>
                <li>To process and fulfill your orders</li>
                <li>To communicate regarding orders and support</li>
                <li>To send newsletters or promotions (if opted in)</li>
                <li>To improve website performance and security</li>
            </ul>

            <h3 class="text-xl font-semibold text-white mb-3">3. Sharing of Your Information</h3>
            <p>We don’t sell or rent your personal data. We only share it with trusted third-party providers like payment processors and shipping partners for order fulfillment.</p>

            <h3 class="text-xl font-semibold text-white mb-3">4. Cookies & Tracking</h3>
            <p>Cookies are used for better browsing and analytics. You may disable them in your browser settings, but it may affect site functionality.</p>

            <h3 class="text-xl font-semibold text-white mb-3">5. Data Security</h3>
            <p>We use security measures to protect your data, but no online system is 100% secure.</p>

            <h3 class="text-xl font-semibold text-white mb-3">6. Your Rights</h3>
            <p>You may request to access, correct, or delete your personal data in accordance with local laws.</p>

            <h3 class="text-xl font-semibold text-white mb-3">7. Updates</h3>
            <p>This policy may be updated periodically. Please review this page regularly for changes.</p>

        </div>
    </div>
</section>

<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html>
