<?php
include "db.php";

// ✅ Protect checkout: only logged-in users
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php?redirect=checkout.php");
    exit();
}

// ✅ Calculate total
$total = 0;
if (!empty($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - MyShop</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .checkout-container { width:80%; margin:20px auto; }
    .checkout-item { display:flex; align-items:center; margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:10px; }
    .checkout-img { width:80px; height:80px; object-fit:cover; margin-right:15px; border-radius:6px; }
    .checkout-info p { margin:5px 0; }
    .checkout-summary { margin-top:20px; text-align:right; }
    .checkout-btn { padding:10px 20px; background:black; color:white; border:none; border-radius:6px; cursor:pointer; }
    .checkout-btn:hover { background:#444; }
    #coupon_code { padding:8px; border:1px solid #ccc; border-radius:5px; }
    #coupon_msg { font-size:14px; margin-top:5px; }
    .checkout-form { margin-top:20px; text-align:left; }
    .checkout-form input, .checkout-form textarea { width:100%; padding:8px; margin:6px 0; border:1px solid #ccc; border-radius:5px; }
  </style>
</head>
<body>

<?php include "navbar.php"; ?>

<main>
  <h2 style="text-align:center; margin-top:20px;">Checkout</h2>

  <?php if (!empty($_SESSION['cart'])): ?>
    <div class="checkout-container">
      <?php foreach ($_SESSION['cart'] as $item): ?>
        <div class="checkout-item">
          <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="checkout-img">
          <div class="checkout-info">
            <p><strong><?= htmlspecialchars($item['name']) ?></strong> (<?= htmlspecialchars($item['size']) ?>)</p>
            <p>₹<?= number_format($item['price'], 2) ?> × <?= $item['quantity'] ?></p>
            <p><strong>Subtotal:</strong> ₹<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
          </div>
        </div>
      <?php endforeach; ?>

      <!-- ✅ Customer Info -->
      <div class="checkout-form">
        <h4>Shipping Information</h4>
        <input type="text" id="customer_name" placeholder="Full Name" required value="<?= $_SESSION['user_name'] ?? '' ?>">
        <input type="text" id="customer_mobile" placeholder="Mobile Number" required>
        <textarea id="customer_address" placeholder="Full Address" rows="3" required></textarea>
      </div>

      <div class="checkout-summary">
        <h3>Total: ₹<span id="total_display"><?= number_format($total, 2) ?></span></h3>

        <!-- ✅ Coupon input -->
        <div style="margin-top:15px;">
          <input type="text" id="coupon_code" placeholder="Enter Coupon Code">
          <button type="button" onclick="applyCoupon()" class="checkout-btn">Apply</button>
          <p id="coupon_msg"></p>
        </div>

        <button id="rzp-button" class="checkout-btn" style="margin-top:20px;">Pay Now</button>
      </div>
    </div>
  <?php else: ?>
    <p style="text-align:center;">Your cart is empty.</p>
  <?php endif; ?>
</main>

<?php include "footer.php"; ?>

<!-- ✅ Razorpay Checkout -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
let discount = 0;
let totalAmount = <?= $total ?>; // original total
let couponType = null;
let couponValue = 0;

// ✅ Apply Coupon
function applyCoupon(){
  const code = document.getElementById("coupon_code").value.trim();
  if(!code){ alert("Enter a coupon code"); return; }

  fetch("apply_coupon.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ code: code })
  })
  .then(res => res.json())
  .then(data => {
    let msg = document.getElementById("coupon_msg");
    if(data.success){
      couponType = data.type;
      couponValue = parseFloat(data.value);

      if (couponType === "percent") {
        discount = (totalAmount * couponValue) / 100;
      } else {
        discount = couponValue;
      }

      let newTotal = totalAmount - discount;
      if(newTotal < 0) newTotal = 0;

      document.getElementById("total_display").innerText = newTotal.toFixed(2);
      msg.style.color = "green";
      msg.innerText = "Coupon applied! Discount: ₹" + discount.toFixed(2);
    } else {
      discount = 0;
      couponType = null;
      couponValue = 0;
      document.getElementById("total_display").innerText = totalAmount.toFixed(2);
      msg.style.color = "red";
      msg.innerText = data.message;
    }
  })
  .catch(err => alert("Error: " + err));
}

document.getElementById('rzp-button').onclick = function(e){
    e.preventDefault();

    // ✅ Collect shipping info
    const name = document.getElementById("customer_name").value.trim();
    const mobile = document.getElementById("customer_mobile").value.trim();
    const address = document.getElementById("customer_address").value.trim();

    if(!name || !mobile || !address){
      alert("Please fill all shipping details!");
      return;
    }

    const finalAmount = (totalAmount - discount) * 100; // convert to paise

    fetch("create_order.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ amount: finalAmount })
    })
    .then(res => res.json())
    .then(order => {
        if (!order.id) {
            alert("Failed to create Razorpay order");
            return;
        }

        var options = {
            "key": "<?= RAZORPAY_KEY_ID ?>",
            "amount": order.amount,
            "currency": order.currency,
            "name": "MyShop",
            "description": "Order Payment",
            "order_id": order.id,
  "handler": function (response){
    fetch("place_order.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature,
            discount: discount,
            customer_name: name,
            customer_mobile: mobile,
            customer_address: address
        })
    })
    .then(res => res.json())
   .then(data => {
    if (data.success) {
        window.location.href = data.redirect; // ✅ dynamic redirect
    } else {
        alert("Order failed: " + data.message);
    }
});

},

            "prefill": {
                "name": name,
                "email": "<?= $_SESSION['user_email'] ?? '' ?>",
                "contact": mobile
            },
            "theme": { "color": "#000" }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    })
    .catch(err => alert("Error: " + err));
}
</script>
</body>
</html>
