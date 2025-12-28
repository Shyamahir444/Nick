<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getDBConnection();

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';

    $errors = [];

    // Validation
    if (empty($username)) {
        $errors[] = 'Please enter a username.';
    }

    if (empty($email)) {
        $errors[] = 'Please enter an email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (empty($birthdate)) {
        $errors[] = 'Please enter your birthdate.';
    }

    if (empty($password)) {
        $errors[] = 'Please enter a password.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if (empty($confirmPassword)) {
        $errors[] = 'Please confirm your password.';
    } elseif ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    // Profile photo check
    if (!isset($_FILES['profilePhoto']) || $_FILES['profilePhoto']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Please upload a profile photo.';
    }

    // If there are validation errors
    if (!empty($errors)) {
        $_SESSION['signup_error'] = implode('<br>', $errors);
        header('Location: signup.php');
        exit();
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['signup_error'] = 'Username or email already exists.';
        header('Location: signup.php');
        exit();
    }

    // Handle profile photo upload
    $uploadDir = 'assets/images/avatars/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = uniqid() . '-' . basename($_FILES['profilePhoto']['name']);
    $targetPath = $uploadDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    $profilePicturePath = '';
    if (in_array($imageFileType, $allowedTypes) && $_FILES['profilePhoto']['size'] < 5000000) { // 5MB limit
        if (move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $targetPath)) {
            $profilePicturePath = $targetPath;
        } else {
            $_SESSION['signup_error'] = 'Error uploading profile photo.';
            header('Location: signup.php');
            exit();
        }
    } else {
        $_SESSION['signup_error'] = 'Invalid image file type or size too large.';
        header('Location: signup.php');
        exit();
    }

    // Hash password and insert user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $insert_stmt = $conn->prepare("INSERT INTO users (username, email, birthdate, password, profile_picture) VALUES (?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("sssss", $username, $email, $birthdate, $hashedPassword, $profilePicturePath);

    if ($insert_stmt->execute()) {
        $_SESSION['signup_success'] = 'Account created successfully! Please login.';
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['signup_error'] = 'Registration failed. Please try again.';
        header('Location: signup.php');
        exit();
    }
}

header('Location: signup.php');
exit();
?>
