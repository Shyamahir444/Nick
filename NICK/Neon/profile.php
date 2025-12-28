<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$success_message = $_SESSION['success_message'] ?? null;
$error_message = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

$conn = getDBConnection();
$user_id = getUserId();

$stmt = $conn->prepare("SELECT username, email, birthdate, profile_picture, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$user) {
    // Should not happen if user is logged in, but as a safeguard
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Your Profile | NEON BLADE</title>
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
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background: #222;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .profile-header img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary);
        margin-bottom: 15px;
    }
    .profile-header h2 {
        font-size: 2rem;
        color: var(--secondary);
    }
    .profile-details {
        width: 100%;
    }
    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #444;
    }
    .detail-item:last-child {
        border-bottom: none;
    }
    .detail-item .label {
        font-weight: 600;
        color: #ccc;
    }
    .detail-item .value {
        color: #fff;
    }
    .password-update-container {
        width: 100%;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #444;
    }
    .password-update-container h3 {
        font-size: 1.5rem;
        color: var(--secondary);
        margin-bottom: 20px;
        text-align: left;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        background: #333;
        border: 1px solid #555;
        color: #fff;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .update-btn {
        padding: 10px 20px;
        background: var(--primary);
        border: none;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 10px;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        color: #fff;
    }
    .alert-success {
        background-color: #2ecc71;
    }
    .alert-danger {
        background-color: #e74c3c;
    }
    .error-text {
        color: var(--primary);
        font-size: 0.9rem;
        margin-top: 5px;
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
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </nav>
</header>

<div class="page-heading">
    <h3>User Profile</h3>
</div>

<div class="profile-container">
    <div class="profile-header">
        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
    </div>
    <div class="profile-details">
        <div class="detail-item">
            <span class="label">Email</span>
            <span class="value"><?php echo htmlspecialchars($user['email']); ?></span>
        </div>
        <div class="detail-item">
            <span class="label">Birthdate</span>
            <span class="value"><?php echo htmlspecialchars(date('F j, Y', strtotime($user['birthdate']))); ?></span>
        </div>
        <div class="detail-item">
            <span class="label">Member Since</span>
            <span class="value"><?php echo htmlspecialchars(date('F j, Y', strtotime($user['created_at']))); ?></span>
        </div>
    </div>

    <div class="password-update-container">
        <h3>Update Password</h3>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form id="passwordUpdateForm" action="update_password.php" method="POST">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="form-control">
                <div id="currentPasswordError" class="error-text"></div>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control">
                <div id="newPasswordError" class="error-text"></div>
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirm New Password</label>
                <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control">
                <div id="confirmNewPasswordError" class="error-text"></div>
            </div>
            <button type="submit" class="update-btn">Update Password</button>
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

document.getElementById('passwordUpdateForm').addEventListener('submit', function(event) {
    let isValid = true;

    const currentPassword = document.getElementById('current_password');
    const newPassword = document.getElementById('new_password');
    const confirmNewPassword = document.getElementById('confirm_new_password');

    const currentPasswordError = document.getElementById('currentPasswordError');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmNewPasswordError = document.getElementById('confirmNewPasswordError');

    // Validate Current Password
    if (currentPassword.value.trim() === '') {
        currentPasswordError.textContent = 'Please enter your current password.';
        isValid = false;
    }

    // Validate New Password
    if (newPassword.value.trim() === '') {
        newPasswordError.textContent = 'Please enter a new password.';
        isValid = false;
    } else if (newPassword.value.length < 6) {
        newPasswordError.textContent = 'Password must be at least 6 characters long.';
        isValid = false;
    }

    // Validate Confirm New Password
    if (confirmNewPassword.value.trim() === '') {
        confirmNewPasswordError.textContent = 'Please confirm your new password.';
        isValid = false;
    } else if (newPassword.value !== confirmNewPassword.value) {
        confirmNewPasswordError.textContent = 'New passwords do not match.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Stop form submission if validation fails
    }
});
</script>
</body>
</html>
