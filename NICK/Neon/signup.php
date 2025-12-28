<?php
require_once 'config.php';

$error = $_SESSION['signup_error'] ?? null;
$success = $_SESSION['signup_success'] ?? null;
unset($_SESSION['signup_error']);
unset($_SESSION['signup_success']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NEON BLADE | Signup</title>
  <base href="/NICK/Neon/">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary: #4c6de3;
      --secondary: #0d0221;
      --light: #ffffff;
      --accent: #f6019d;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--secondary);
      color: var(--light);
      min-height: 100vh;
    }

    #video-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
      opacity: 0.3;
    }

    .header-area {
      background: rgba(13, 2, 33, 0.9);
      padding: 1rem 2rem;
      border-bottom: 1px solid var(--primary);
    }

    .nav-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1400px;
      margin: 0 auto;
    }

    .logo img {
      width: 70px;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
    }

    .nav-links a {
      text-decoration: none;
      color: var(--light);
      font-weight: 500;
    }

    .nav-links a.active {
      color: var(--primary);
    }

    .page-heading {
      padding: 8rem 2rem 2rem;
      text-align: center;
    }

    .page-heading h3 {
      font-size: 2.5rem;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      color: transparent;
      text-transform: uppercase;
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 3rem 2rem;
    }

    .login-form {
      background: rgba(26, 26, 46, 0.8);
      border-radius: 16px;
      padding: 3rem;
      width: 100%;
      max-width: 500px;
      border: 1px solid var(--primary);
      box-shadow: 0 10px 30px rgba(76, 109, 227, 0.3);
    }

    .form-heading {
      text-align: center;
      margin-bottom: 2rem;
    }

    .form-heading h2 {
      font-size: 2.2rem;
      font-weight: 700;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      color: transparent;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.8rem;
      color: var(--light);
      font-weight: 500;
    }

    .form-control {
      width: 100%;
      padding: 1rem;
      border-radius: 8px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      background: rgba(255, 255, 255, 0.1);
      color: var(--light);
      font-size: 1rem;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      background: rgba(76, 109, 227, 0.1);
      box-shadow: 0 0 0 2px rgba(76, 109, 227, 0.3);
    }

    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 4px;
    }

    .submit-btn {
      width: 100%;
      padding: 1rem;
      border-radius: 8px;
      border: none;
      background: linear-gradient(45deg, var(--primary), var(--accent));
      color: white;
      font-weight: 600;
      font-size: 1.1rem;
      cursor: pointer;
      transition: 0.3s;
    }

    .submit-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(76, 109, 227, 0.6);
    }

    footer {
      margin-top: 150px;
      background-color: rgba(76, 109, 227, 0.2);
      min-height: 120px;
      border-radius: 150px 150px 0 0;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 2rem;
    }
  </style>
</head>

<body>
  <video autoplay muted loop id="video-background">
    <source src="assets/images/kakashi.mp4" type="video/mp4">
  </video>

  <header class="header-area">
    <div class="nav-container">
      <a href="index.php" class="logo">
        <img src="assets/images/logo1.png" alt="NEON BLADE Logo">
      </a>
      <nav class="nav-links">
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
        <?php else: ?>
            <a href="signup.php" class="active">Signup</a>
            <a href="login.php">Login In</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <div class="page-heading">
    <h3>SIGN UP</h3>
  </div>

  <div class="login-container">
    <div class="login-form">
      <div class="form-heading">
        <h2>Create your account</h2>
        <p>Join NEON BLADE to get the best gaming deals.</p>
      </div>

      <form id="signupForm" method="post" action="registerprocess.php" enctype="multipart/form-data">
        <div class="form-group">
          <label for="username">USERNAME</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username">
          <div class="error-message" id="usernameError"></div>
        </div>

        <div class="form-group">
          <label for="email">EMAIL</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
          <div class="error-message" id="emailError"></div>
        </div>

        <div class="form-group">
          <label for="birthdate">BIRTHDATE</label>
          <input type="date" class="form-control" id="birthdate" name="birthdate">
          <div class="error-message" id="birthdateError"></div>
        </div>

        <div class="form-group">
          <label for="password">PASSWORD</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Create a password">
          <div class="error-message" id="passwordError"></div>
        </div>

        <div class="form-group">
          <label for="confirmPassword">CONFIRM PASSWORD</label>
          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password">
          <div class="error-message" id="confirmPasswordError"></div>
        </div>

        <div class="form-group">
          <label for="profilePhoto">PROFILE PHOTO</label>
          <input type="file" class="form-control" id="profilePhoto" name="profilePhoto" accept="image/*">
          <div class="error-message" id="profilePhotoError"></div>
        </div>

        <button type="submit" class="submit-btn">
          <i class="fas fa-user-plus"></i> SIGN UP
        </button>

        <div class="register-link">
          Already have an account? <a href="login.php">Login here</a>
        </div>
      </form>
    </div>
  </div>

  <footer>
    <p>© 2025 NEON BLADE. All Rights Reserved.</p>
  </footer>

  <script>
    document.getElementById('signupForm').addEventListener('submit', function (event) {
      let isValid = true;

      const username = document.getElementById('username');
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      const confirmPassword = document.getElementById('confirmPassword');
      const profilePhoto = document.getElementById('profilePhoto');
      const birthdate = document.getElementById('birthdate');

      const usernameError = document.getElementById('usernameError');
      const emailError = document.getElementById('emailError');
      const passwordError = document.getElementById('passwordError');
      const confirmPasswordError = document.getElementById('confirmPasswordError');
      const profilePhotoError = document.getElementById('profilePhotoError');
      const birthdateError = document.getElementById('birthdateError');

      usernameError.textContent = '';
      emailError.textContent = '';
      passwordError.textContent = '';
      confirmPasswordError.textContent = '';
      profilePhotoError.textContent = '';
      birthdateError.textContent = '';

      if (username.value.trim() === '') {
        usernameError.textContent = 'Please enter your username';
        isValid = false;
      }

      if (email.value.trim() === '') {
        emailError.textContent = 'Please enter your Email';
        isValid = false;
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        emailError.textContent = 'Please enter a valid Email address';
        isValid = false;
      }

      if (password.value.trim() === '') {
        passwordError.textContent = 'Please enter your password';
        isValid = false;
      } else if (password.value.length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters';
        isValid = false;
      }

      if (confirmPassword.value.trim() === '') {
        confirmPasswordError.textContent = 'Please confirm your password';
        isValid = false;
      } else if (password.value !== confirmPassword.value) {
        confirmPasswordError.textContent = 'Passwords do not match';
        isValid = false;
      }

      if (profilePhoto.value === '') {
        profilePhotoError.textContent = 'Please upload your profile photo';
        isValid = false;
      }

      if (birthdate.value === '') {
        birthdateError.textContent = 'Please enter your birthdate';
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  </script>
</body>
</html>
