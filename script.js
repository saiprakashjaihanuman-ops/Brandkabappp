// ---------------- NAVBAR ----------------

// Hamburger menu toggle
const hamburger = document.getElementById("hamburger");
const menu = document.getElementById("menu");

hamburger.addEventListener("click", () => {
    menu.classList.toggle("show");
});

// Toggle user dropdown (if available)
const userIcon = document.getElementById("userIcon");
if (userIcon) {
    userIcon.addEventListener("click", () => {
        document.querySelector(".user-dropdown").classList.toggle("active");
    });
}

// Close dropdown if clicked outside
document.addEventListener("click", (e) => {
    const dropdown = document.querySelector(".user-dropdown");
    if (dropdown && !dropdown.contains(e.target) && e.target.id !== "userIcon") {
        dropdown.classList.remove("active");
    }
});

// ---------------- CART ----------------
document.addEventListener("DOMContentLoaded", () => {
    const cartIcon = document.getElementById("cartIcon");
    const sideCart = document.getElementById("sideCart");
    const closeCart = document.getElementById("closeCart");
    const cartItems = document.getElementById("cartItems");
    const cartTotal = document.getElementById("cartTotal");
    const cartCount = document.getElementById("cartCount");

    // ✅ Reset badge count ONLY on hard reload
    if (performance.navigation.type === 1) {
        cartCount.innerText = 0;
    }

    // Open cart
    if (cartIcon) {
        cartIcon.addEventListener("click", () => {
            sideCart.classList.add("open");
        });
    }

    // Close cart
    if (closeCart) {
        closeCart.addEventListener("click", () => {
            sideCart.classList.remove("open");
        });
    }

    // Listen for Add to Cart forms
    const forms = document.querySelectorAll("form[action='add_to_cart.php']");
    forms.forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch("add_to_cart.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    cartCount.innerText = data.cartCount;

                    // If empty message exists, remove it
                    const emptyMsg = cartItems.querySelector("p");
                    if (emptyMsg) emptyMsg.remove();

                    // Append new item
                    const div = document.createElement("div");
                    div.classList.add("cart-item");
                    div.setAttribute("data-id", data.item.id);
                    div.setAttribute("data-size", data.item.size);
                    div.innerHTML = `
                        <img src="${data.item.image}" alt="">
                        <div class="cart-info">
                            <p>${data.item.name} (${data.item.size})</p>
                            <p>₹${parseFloat(data.item.price).toFixed(2)}</p>
                            <div class="cart-controls">
                                <input type="number" value="${data.item.quantity}" min="1" class="cart-qty">
                                <button class="delete-item">&times;</button>
                            </div>
                        </div>
                    `;
                    cartItems.appendChild(div);

                    // Recalculate total
                    updateCartTotal();

                    // Auto open cart after adding
                    sideCart.classList.add("open");
                }
            })
            .catch(err => console.error(err));
        });
    });

    // Function to recalc total
    function updateCartTotal() {
        let total = 0;
        let count = 0;

        document.querySelectorAll("#cartItems .cart-item").forEach(item => {
            const price = parseFloat(item.querySelector("p:nth-child(2)").innerText.replace("₹", ""));
            const qty = parseInt(item.querySelector(".cart-qty").value);
            total += price * qty;
            count += qty;
        });

        cartTotal.innerText = "Total: ₹" + total.toFixed(2);
        cartCount.innerText = count;
    }

    // Delegate events for qty change and delete
    cartItems.addEventListener("input", (e) => {
        if (e.target.classList.contains("cart-qty")) {
            const itemDiv = e.target.closest(".cart-item");
            const id = itemDiv.getAttribute("data-id");
            const size = itemDiv.getAttribute("data-size");
            const newQty = e.target.value;

            // Update backend
            fetch("update_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${id}&size=${size}&quantity=${newQty}`
            });

            updateCartTotal();
        }
    });

    cartItems.addEventListener("click", (e) => {
        if (e.target.classList.contains("delete-item")) {
            const itemDiv = e.target.closest(".cart-item");
            const id = itemDiv.getAttribute("data-id");
            const size = itemDiv.getAttribute("data-size");

            // Remove from backend
            fetch("remove_from_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${id}&size=${size}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    itemDiv.remove();
                    cartCount.innerText = data.cartCount;
                    updateCartTotal();
                }
            });
        }
    });
});
