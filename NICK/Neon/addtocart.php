<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Your Cart | NEON BLADE</title>
<base href="/NICK/Neon/">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    :root {
      --primary: #ff2a6d;
      --secondary: #05d9e8;
      --dark: #0d0221;
      --dark-alt: #1a1a2e;
      --light: #d1f7ff;
    }
    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--secondary);
    }
    .user-menu { position: relative; display: flex; align-items: center; }
    .user-menu .profile-pic { cursor: pointer; }
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 55px;
      right: 0;
      background: var(--dark-alt);
      border-radius: 8px;
      padding: 0.5rem 0;
      list-style: none;
      width: 150px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
      border: 1px solid rgba(255,255,255,0.1);
    }
    .dropdown-menu.show { display: block; }
    .dropdown-menu a { display: block; padding: 0.75rem 1.5rem; color: var(--light); text-decoration: none; transition: background-color 0.2s; }
    .dropdown-menu a:hover { background-color: var(--primary); color: white !important; }

body {
    font-family: 'Poppins', sans-serif;
    background: #111;
    color: #fff;
    margin: 0;
}
header {
    background: rgba(13, 2, 33, 0.9);
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
nav { display: flex; align-items: center; gap: 20px; }

header img {
    width: 60px;
}
nav a {
    color: #fff;
    text-decoration: none;
    margin: 0 10px;
    font-weight: 500;
}
.page-heading {
    text-align: center;
    padding: 60px 0 20px;
}
.page-heading h3 {
    font-size: 28px;
    margin-bottom: 10px;
}
.cart-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}
.cart-section {
    background: #222;
    padding: 20px;
    border-radius: 10px;
}
.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #333;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}
.item-title {
    font-weight: 600;
}
.item-price, .item-total {
    color: #f33;
    font-weight: 600;
}
.item-quantity {
    display: flex;
    align-items: center;
    gap: 5px;
}
.quantity-btn {
    background: #f33;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}
.remove-btn {
    background: none;
    border: none;
    color: #f33;
    font-size: 18px;
    cursor: pointer;
}
.cart-total {
    display: flex;
    justify-content: space-between;
    font-weight: 600;
    margin-top: 15px;
}
.checkout-btn {
    width: 100%;
    padding: 10px;
    margin-top: 15px;
    background: #f33;
    border: none;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    border-radius: 5px;
}
.empty-cart {
    text-align: center;
    padding: 20px;
    color: #ccc;
}
footer {
    text-align: center;
    padding: 20px;
    background: #d10000;
    margin-top: 40px;
}
</style>
</head>

<body>
<header>
    <a href="index.php"><img src="assets/images/logo1.png" alt="Logo"></a>
    <nav>
        <a href="index.php">Home</a>
        <a href="shop.php">Our Shop</a>
        <a href="contact.php">Contact Us</a>
        <?php if (isLoggedIn()): ?>
            <div class="user-menu" onclick="toggleDropdown()">
                <a href="addtocart.php" class="active">Cart</a>
                <img src="<?php echo getProfilePicture(); ?>" alt="Profile" class="profile-pic" id="profile-pic">
                <ul class="dropdown-menu" id="dropdown-menu">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="signup.php">Signup</a>
            <a href="login.php">Login In</a>
        <?php endif; ?>
    </nav>
</header>

<div class="page-heading">
    <h3>Your Cart</h3>
</div>

<div class="cart-container">
    <div class="cart-section">
        <div id="cart-items"></div>
        <div id="cart-summary">
            <div class="cart-total">
                <span>Total:</span>
                <span id="total-price">$0.00</span>
            </div>
            <?php if (isLoggedIn()): ?>
                <button class="checkout-btn" onclick="location.href='checkout.php';">Checkout</button>
            <?php else: ?>
                <button class="checkout-btn" onclick="location.href='login.php';">Login to Checkout</button>
            <?php endif; ?>
        </div>
        <div class="empty-cart" id="empty-cart" style="display:none;">
            <p>Your cart is empty.</p>
            <a href="shop.php" style="color:#f33;">Go to Shop</a>
        </div>
    </div>
</div>

<footer>
    © 2025 NEON BLADE. All Rights Reserved.
</footer>

<script>
function toggleDropdown() {
  document.getElementById('dropdown-menu').classList.toggle('show');
}
window.onclick = function(event) {
  if (!event.target.matches('#profile-pic')) {
    var dropdowns = document.getElementsByClassName("dropdown-menu");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

let cartData = [];

function loadCart() {
    <?php if (!isLoggedIn()): ?>
        const cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '<p style="text-align: center;">Please login to view and manage your cart.</p>';
        document.getElementById('cart-summary').style.display = 'none';
        document.getElementById('empty-cart').style.display = 'none';
        return;
    <?php endif; ?>
    const formData = new FormData();
    formData.append('action', 'get');
    
    fetch('cart_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cartData = data.cart || [];
            displayCart();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayCart() {
    const cartItemsContainer = document.getElementById('cart-items');
    const summary = document.getElementById('cart-summary');
    const empty = document.getElementById('empty-cart');
    let total = 0;
    cartItemsContainer.innerHTML = '';

    if (cartData.length === 0) {
        summary.style.display = 'none';
        empty.style.display = 'block';
        return;
    } else {
        summary.style.display = 'block';
        empty.style.display = 'none';
    }

    cartData.forEach((item, i) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        const productId = item.product_id || item.id;
        cartItemsContainer.innerHTML += `
            <div class="cart-item">
                <div>
                    <div class="item-title">${item.title}</div>
                    <div class="item-price">$${item.price.toFixed(2)}</div>
                    <div class="item-quantity">
                        <button class="quantity-btn" onclick="updateQuantity(${productId}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity(${productId}, 1)">+</button>
                    </div>
                </div>
                <div>
                    <div class="item-total">$${itemTotal.toFixed(2)}</div>
                    <button class="remove-btn" onclick="removeItem(${productId})">✖</button>
                </div>
            </div>`;
    });

    document.getElementById('total-price').textContent = `$${total.toFixed(2)}`;
}

function updateQuantity(productId, change) {
    const item = cartData.find(i => (i.product_id || i.id) == productId);
    if (!item) return;
    
    const newQty = item.quantity + change;
    if (newQty < 1) {
        removeItem(productId);
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('product_id', productId);
    formData.append('quantity', newQty);
    
    fetch('cart_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
    loadCart();
}
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function removeItem(productId) {
    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('product_id', productId);
    
    fetch('cart_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
    loadCart();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

window.onload = loadCart;
</script>
</body>
</html>
