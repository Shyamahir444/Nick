<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $conn = getDBConnection();
        
        // Check if user exists
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $email;
                
                // Transfer guest cart to user cart if exists
                if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
                    foreach ($_SESSION['guest_cart'] as $product_id => $quantity) {
                        // Check if item already exists in user's cart
                        $check_stmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
                        $check_stmt->bind_param("ii", $user['id'], $product_id);
                        $check_stmt->execute();
                        $check_result = $check_stmt->get_result();
                        
                        if ($check_result->num_rows > 0) {
                            $cart_item = $check_result->fetch_assoc();
                            $new_quantity = $cart_item['quantity'] + $quantity;
                            $update_stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
                            $update_stmt->bind_param("ii", $new_quantity, $cart_item['id']);
                            $update_stmt->execute();
                            $update_stmt->close();
                        } else {
                            $insert_stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
                            $insert_stmt->bind_param("iii", $user['id'], $product_id, $quantity);
                            $insert_stmt->execute();
                            $insert_stmt->close();
                        }
                        
                        $check_stmt->close();
                    }
                    unset($_SESSION['guest_cart']);
                }
                
                $stmt->close();
                $conn->close();
                
                header('Location: index.php');
                exit();
            } else {
                $error = 'Invalid email or password';
            }
        } else {
            $error = 'Invalid email or password';
        }
        
        $stmt->close();
        $conn->close();
    }
}

// Return error as JSON if AJAX request, otherwise redirect
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => $error]);
    exit();
}

if ($error) {
    $_SESSION['login_error'] = $error;
}
header('Location: login.php');
exit();
?>