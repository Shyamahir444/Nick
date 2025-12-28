<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Password Updated | NEON BLADE</title>
<base href="/NICK/Neon/">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    :root {
      --primary: #ff2a6d;
      --secondary: #05d9e8;
      --dark: #0d0221;
      --success: #2ecc71;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: #111;
        color: #fff;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        text-align: center;
    }
    .success-container {
        padding: 40px 20px;
        max-width: 600px;
        background: #222;
        border-radius: 10px;
    }
    .success-icon {
        font-size: 5rem;
        color: var(--success);
        margin-bottom: 20px;
    }
    .success-container h1 {
        font-size: 2.5rem;
        color: var(--success);
        margin-bottom: 15px;
    }
    .success-container p {
        font-size: 1.1rem;
        margin-bottom: 30px;
    }
    .profile-btn {
        display: inline-block;
        padding: 12px 30px;
        background: var(--primary);
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 600;
        transition: background 0.3s;
    }
    .profile-btn:hover {
        background: #d10000;
    }
</style>
</head>
<body>

<div class="success-container">
    <div class="success-icon"><i class="fas fa-check-circle"></i></div>
    <h1>Success!</h1>
    <p>Your password was updated successfully.</p>
    <a href="profile.php" class="profile-btn">Go to Profile</a>
</div>

</body>
</html>