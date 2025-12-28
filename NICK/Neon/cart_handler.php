<?php
require_once 'config.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$conn = getDBConnection();

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.', 'cart' => []]);
    exit();
} else {
    // For logged-in users, use database
    $user_id = getUserId();
    
    switch ($action) {
        case 'add':
            $product_id = intval($_POST['product_id']);
            $quantity = intval($_POST['quantity'] ?? 1);
            
            // Check if item already exists in cart
            $stmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Update quantity
                $row = $result->fetch_assoc();
                $new_quantity = $row['quantity'] + $quantity;
                $update_stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
                $update_stmt->bind_param("ii", $new_quantity, $row['id']);
                $update_stmt->execute();
                $update_stmt->close();
            } else {
                // Insert new item
                $insert_stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
                $insert_stmt->execute();
                $insert_stmt->close();
            }
            $stmt->close();
            
            echo json_encode(['success' => true, 'message' => 'Item added to cart']);
            break;
            
        case 'remove':
            $product_id = intval($_POST['product_id']);
            $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
            $stmt->close();
            
            echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
            break;
            
        case 'update':
            $product_id = intval($_POST['product_id']);
            $quantity = intval($_POST['quantity']);
            
            if ($quantity <= 0) {
                $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("ii", $user_id, $product_id);
                $stmt->execute();
                $stmt->close();
            } else {
                $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("iii", $quantity, $user_id, $product_id);
                $stmt->execute();
                $stmt->close();
            }
            
            echo json_encode(['success' => true, 'message' => 'Cart updated']);
            break;
            
        case 'get':
            $stmt = $conn->prepare("
                SELECT c.id, c.product_id, c.quantity, p.title, p.price 
                FROM cart_items c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ?
            ");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $cart = [];
            while ($row = $result->fetch_assoc()) {
                $cart[] = [
                    'id' => $row['id'],
                    'product_id' => $row['product_id'],
                    'title' => $row['title'],
                    'price' => floatval($row['price']),
                    'quantity' => intval($row['quantity'])
                ];
            }
            $stmt->close();
            
            echo json_encode(['success' => true, 'cart' => $cart]);
            break;
    }
}

$conn->close();
?>