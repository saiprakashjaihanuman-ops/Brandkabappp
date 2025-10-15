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
    <title>Terms & Conditions - Brandkabappp</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<header style="padding:20px; text-align:center;">
    <h2>Terms & Conditions</h2>
</header>

<section id="terms-and-conditions-section" style="padding:40px; background:#111; color:#ccc;">
    <div class="container" style="max-width:900px; margin:auto;">
        <h2 class="text-3xl font-bold text-center text-white mb-12">Terms and Conditions</h2>
        <div class="policy-content" style="line-height:1.8;">

            <h3 class="text-xl font-semibold text-white mb-3">1. General Terms</h3>
            <p><strong>1.1 Eligibility:</strong> By using our website, you confirm that you are at least 18 years old or accessing the site under the supervision of a parent/guardian.</p>
            <p><strong>1.2 Modifications:</strong> We reserve the right to amend these terms at any time. Updates will be posted on this page, and continued use of the site constitutes acceptance.</p>

            <h3 class="text-xl font-semibold text-white mb-3">2. Products and Services</h3>
            <p><strong>2.1 Product Descriptions:</strong> We strive for accuracy but do not guarantee all product details are error-free or current.</p>
            <p><strong>2.2 Pricing:</strong> Prices are in INR and may change without notice. Taxes and shipping charges are shown at checkout.</p>
            <p><strong>2.3 Order Acceptance:</strong> We may refuse or cancel orders due to product availability, pricing errors, or payment issues.</p>

            <h3 class="text-xl font-semibold text-white mb-3">3. Payment Terms</h3>
            <p><strong>3.1 Payment Methods:</strong> We accept credit/debit cards, UPI, and other listed methods. Payment is required at purchase.</p>
            <p><strong>3.2 Payment Security:</strong> Transactions are processed via secure gateways. We are not responsible for breaches outside our system.</p>

            <h3 class="text-xl font-semibold text-white mb-3">4. Return and Exchange</h3>
            <p>Please see our <a href="refund.php" class="text-white hover:underline">Refund & Exchange Policy</a> for details.</p>

            <h3 class="text-xl font-semibold text-white mb-3">5. Intellectual Property</h3>
            <p>All website content (text, images, logos, designs) is owned by Brandkabappp and protected by copyright/trademark laws. Unauthorised use is prohibited.</p>

            <h3 class="text-xl font-semibold text-white mb-3">6. Limitation of Liability</h3>
            <p>We are not liable for indirect, incidental, or consequential damages from the use or inability to use our website or products.</p>

            <h3 class="text-xl font-semibold text-white mb-3">7. Contact Information</h3>
            <p>For questions, contact us at:  
                <a href="mailto:brandkabaapp4@gmail.com" class="text-white font-semibold hover:underline">brandkabaapp4@gmail.com</a>
            </p>

        </div>
    </div>
</section>

<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html>
