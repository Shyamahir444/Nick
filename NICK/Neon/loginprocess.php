<?php
require_once 'config.php';
$conn = getDBConnection(); // Your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($username)) {
        $_SESSION['login_error'] = "Please enter your username or email.";
        header("Location: login.php");
        exit();
    } elseif (empty($password)) {
        $_SESSION['login_error'] = "Please enter your password.";
        header("Location: login.php");
        exit();
    }

    // Prepare SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // If password is hashed in DB
        if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['profile_picture'] = $user['profile_picture'];

            // Transfer guest cart to user cart if it exists
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
                unset($_SESSION['guest_cart']); // Clear guest cart after transfer
            }

            header("Location: index.php"); // redirect to home
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid password!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Username not found
        $_SESSION['login_error'] = "No account found with this username or email!";
        header("Location: login.php");
        exit();
    }

} else {
    // Accessed directly
    header("Location: login.php");
    exit();
}
