<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: profile.php');
    exit();
}

$user_id = getUserId();
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_new_password = $_POST['confirm_new_password'] ?? '';

// --- Validation ---
if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
    $_SESSION['error_message'] = 'Please fill in all password fields.';
    header('Location: profile.php');
    exit();
}

if (strlen($new_password) < 6) {
    $_SESSION['error_message'] = 'New password must be at least 6 characters long.';
    header('Location: profile.php');
    exit();
}

if ($new_password !== $confirm_new_password) {
    $_SESSION['error_message'] = 'New passwords do not match.';
    header('Location: profile.php');
    exit();
}

$conn = getDBConnection();

// --- Verify Current Password ---
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($current_password, $user['password'])) {
    $_SESSION['error_message'] = 'Your current password is not correct.';
    header('Location: profile.php');
    exit();
}

// --- Update to New Password ---
$hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

$update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$update_stmt->bind_param("si", $hashed_new_password, $user_id);

if ($update_stmt->execute()) {
    // Redirect to the success page instead of directly to the profile
    header('Location: update_success.php');
} else {
    $_SESSION['error_message'] = 'Failed to update password. Please try again.';
    header('Location: profile.php');
}

$update_stmt->close();
$conn->close();
exit();
?>