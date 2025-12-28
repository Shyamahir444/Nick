<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$conn = getDBConnection();
$user_id = getUserId();

$stmt = $conn->prepare("
    SELECT c.product_id, c.quantity, p.title, p.price 
    FROM cart_items c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
$stmt->close();

if (empty($cart_items)) {
    header('Location: shop.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout | NEON BLADE</title>
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
    .page-heading {
        text-align: center;
        padding: 60px 0 20px;
    }
    .page-heading h3 {
        font-size: 28px;
        margin-bottom: 10px;
    }
    .checkout-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .checkout-section {
        background: #222;
        padding: 20px;
        border-radius: 10px;
    }
    .order-summary h4 {
        font-size: 20px;
        border-bottom: 1px solid #444;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        margin-top: 15px;
        font-size: 18px;
        color: var(--primary);
    }
    .payment-details {
        margin-top: 25px;
        border-top: 1px solid #444;
        padding-top: 20px;
    }
    .payment-details h4 {
        font-size: 20px;
        margin-bottom: 15px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        background: #333;
        border: 1px solid #555;
        color: #fff;
        border-radius: 5px;
    }
    .error-message {
      color: #ff2a6d;
      font-size: 14px;
      margin-top: 5px;
    }
    .process-btn {
        width: 100%;
        padding: 10px;
        margin-top: 15px;
        background: var(--primary);
        border: none;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
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
                <a href="addtocart.php">Cart</a>
                <img src="<?php echo getProfilePicture(); ?>" alt="Profile" class="profile-pic" id="profile-pic">
                <ul class="dropdown-menu" id="dropdown-menu">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </nav>
</header>

<div class="page-heading">
    <h3>Checkout</h3>
</div>

<div class="checkout-container">
    <div class="checkout-section">
        <div class="order-summary">
            <h4>Order Summary</h4>
            <?php foreach ($cart_items as $item): ?>
                <div class="summary-item">
                    <span><?php echo htmlspecialchars($item['title']); ?> (x<?php echo $item['quantity']; ?>)</span>
                    <span>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                </div>
            <?php endforeach; ?>
            <div class="summary-total">
                <span>Total:</span>
                <span>$<?php echo number_format($total, 2); ?></span>
            </div>
        </div>
        <form id="checkoutForm" action="process_checkout.php" method="POST">
            <div class="payment-details">
                <h4>Payment Information</h4>
                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX">
                    <div class="error-message" id="cardNumberError"></div>
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="text" id="expiry_date" name="expiry_date" class="form-control" placeholder="MM/YY">
                    <div class="error-message" id="expiryDateError"></div>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123">
                    <div class="error-message" id="cvvError"></div>
                </div>
            </div>
            <button type="submit" class="process-btn">Complete Purchase</button>
        </form>
    </div>
</div>

<footer>
    © 2025 NEON BLADE. All Rights Reserved.
</footer>

<script>
function toggleDropdown() {
  document.getElementById('dropdown-menu').classList.toggle('show');
}

const cardNumberInput = document.getElementById('card_number');
const expiryDateInput = document.getElementById('expiry_date');
const cvvInput = document.getElementById('cvv');

cardNumberInput.addEventListener('input', () => {
    document.getElementById('cardNumberError').textContent = '';
});

expiryDateInput.addEventListener('input', () => {
    document.getElementById('expiryDateError').textContent = '';
});

cvvInput.addEventListener('input', () => {
    document.getElementById('cvvError').textContent = '';
});

document.getElementById('checkoutForm').addEventListener('submit', function (event) {
    let isValid = true;

    const cardNumber = document.getElementById('card_number');
    const expiryDate = document.getElementById('expiry_date');
    const cvv = document.getElementById('cvv');

    const cardNumberError = document.getElementById('cardNumberError');
    const expiryDateError = document.getElementById('expiryDateError');
    const cvvError = document.getElementById('cvvError');

    // Card Number validation
    if (cardNumber.value.trim() === '') {
        cardNumberError.textContent = 'Please enter your card number.';
        isValid = false;
    } else if (!/^\d{4}-?\d{4}-?\d{4}-?\d{4}$/.test(cardNumber.value.trim())) {
        cardNumberError.textContent = 'Please enter a valid card number format (e.g., XXXX-XXXX-XXXX-XXXX).';
        isValid = false;
    }

    // Expiry Date validation
    if (expiryDate.value.trim() === '') {
        expiryDateError.textContent = 'Please enter the expiry date.';
        isValid = false;
    } else if (!/^(0[1-9]|1[0-2])\/?([0-9]{2})$/.test(expiryDate.value.trim())) {
        expiryDateError.textContent = 'Please enter a valid expiry date format (MM/YY).';
        isValid = false;
    }

    // CVV validation
    if (cvv.value.trim() === '') {
        cvvError.textContent = 'Please enter the CVV.';
        isValid = false;
    } else if (!/^\d{3,4}$/.test(cvv.value.trim())) {
        cvvError.textContent = 'Please enter a valid 3 or 4 digit CVV.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Stop form submission if validation fails
    }
});
</script>
</body>
</html>