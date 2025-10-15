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
    <title>Refund & Exchange Policy - Brandkabappp</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<header style="padding:20px; text-align:center;">
    <h2>Refund & Exchange Policy</h2>
</header>

<section id="refund-policy-section" style="padding:40px; background:#000; color:#ccc;">
    <div class="container" style="max-width:900px; margin:auto;">
        <h2 class="text-3xl font-bold text-center text-white mb-12">Refund and Exchange Policy</h2>
        <div class="policy-content" style="line-height:1.8;">

            <p>We want you to be completely satisfied with your purchase. If you face any issues, please read our refund and exchange policy below:</p>

            <h3 class="text-xl font-semibold text-white mb-3">1. No Returns or Refunds</h3>
            <p><strong>Policy Overview:</strong> Due to the nature of our products, we do not accept returns or refunds for any items purchased. Please review product details carefully before buying.</p>

            <h3 class="text-xl font-semibold text-white mb-3">2. Resolution</h3>
            <p>Issues must be reported within <strong>24 hours</strong> of delivery. Our team will verify the issue and provide a resolution within 7 days. Verification of damage/defect may be required.</p>

            <h3 class="text-xl font-semibold text-white mb-3">3. Replacement</h3>
            <p>Once the damaged product is returned and verified, a replacement/exchanged product will be shipped within 6–7 days.</p>

            <h3 class="text-xl font-semibold text-white mb-3">4. Contact Information</h3>
            <p>For assistance, contact us at:  
                <a href="mailto:support@vestease.in" class="text-white font-semibold hover:underline">
                    support@vestease.in
                </a>
            </p>

        </div>
    </div>
</section>

<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html>
