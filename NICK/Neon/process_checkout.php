<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: checkout.php');
    exit();
}

$conn = getDBConnection();
$user_id = getUserId();

// --- Mock Payment Processing ---
// In a real application, you would integrate a payment gateway API here.
$card_number = trim($_POST['card_number'] ?? '');
$expiry_date = trim($_POST['expiry_date'] ?? '');
$cvv = trim($_POST['cvv'] ?? '');

// Basic validation to ensure fields are not empty.
if (empty($card_number) || empty($expiry_date) || empty($cvv)) {
    die("Please fill out all payment details.");
}

// Start a transaction
$conn->begin_transaction();

try {
    // 1. Get cart items for the user
    $cart_stmt = $conn->prepare("
        SELECT c.product_id, c.quantity, p.price 
        FROM cart_items c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?
    ");
    $cart_stmt->bind_param("i", $user_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();

    $cart_items = [];
    $total_amount = 0;
    while ($item = $cart_result->fetch_assoc()) {
        $cart_items[] = $item;
        $total_amount += $item['price'] * $item['quantity'];
    }
    $cart_stmt->close();

    if (empty($cart_items)) {
        header('Location: shop.php');
        exit();
    }

    // 2. Create a new order
    $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'completed')");
    $order_stmt->bind_param("id", $user_id, $total_amount);
    $order_stmt->execute();
    $order_id = $order_stmt->insert_id;
    $order_stmt->close();

    // 3. Insert items into order_items table
    $order_item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart_items as $item) {
        $order_item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $order_item_stmt->execute();
    }
    $order_item_stmt->close();

    // 4. Clear the user's cart
    $clear_cart_stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $clear_cart_stmt->bind_param("i", $user_id);
    $clear_cart_stmt->execute();
    $clear_cart_stmt->close();

    // If all good, commit the transaction
    $conn->commit();

    // Redirect to a success page
    header('Location: order_success.php?order_id=' . $order_id);

} catch (Exception $e) {
    $conn->rollback();
    // Handle error, maybe log it and show a generic error page
    die("There was an error processing your order. Please try again. Error: " . $e->getMessage());
}

$conn->close();