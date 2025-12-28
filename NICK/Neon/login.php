<?php
require_once 'config.php';

$error = '';
if (isset($_SESSION['login_error'])) {
  $error = $_SESSION['login_error'];
  unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
 
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NEON BLADE | Login</title>
  <base href="/NICK/Neon/">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #00f9ff;
      --secondary: #ff2a6d;
      --dark: #0d0221;
      --light: #d1f7ff;
    }
* { 
  margin: 0; 
  padding: 0; 
  box-sizing: border-box; 
}

body { 
  font-family: 'Poppins', sans-serif; 
  background-color: var(--dark); 
  color: var(--light); 
  min-height: 100vh; 
  overflow-x: hidden; 
}

#video-background { 
  position: fixed; 
  top: 0; 
  left: 0; 
  width: 100%; 
  height: 100%; 
  object-fit: cover; 
  z-index: -1; 
  opacity: 0.35; 
}

.header-area { 
  background: rgba(13, 2, 33, 0.9); 
  padding: 1rem 2rem; 
  position: sticky; 
  top: 0; 
  z-index: 1000;
  backdrop-filter: blur(10px); 
  border-bottom: 1px solid rgba(5, 217, 232, 0.2); 
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
  height: auto; 
  transition: transform 0.3s; 
}

.logo:hover img { 
  transform: scale(1.1); 
}

.nav-links { 
  display: flex; 
  gap: 2rem; 
}

.nav-links a { 
  text-decoration: none; 
  color: var(--light); 
  font-weight: 500; 
  font-size: 1.1rem; 
  position: relative; 
  padding: 0.5rem 0; 
  transition: color 0.3s; 
}

.nav-links a:hover { 
  color: var(--secondary); 
}

.nav-links a.active { 
  color: var(--primary); 
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
.nav-links a:hover {
    color: var(--primary);
}
.nav-links a.active {
    color: var(--primary);
}
.page-heading { 
  padding: 6rem 2rem 2rem; 
  text-align: center; 
}

.page-heading h3 { 
  font-size: 2.5rem; 
  margin-bottom: 1rem; 
  background: linear-gradient(90deg, var(--primary), var(--secondary)); 
  -webkit-background-clip: text; 
  background-clip: text; 
  color: transparent; 
  text-transform: uppercase; 
}

.breadcrumb { 
  display: flex; 
  justify-content: center; 
  gap: 0.5rem; 
  font-size: 0.9rem; 
  color: var(--light); 
}

.breadcrumb a { 
  color: var(--secondary); 
  text-decoration: none; 
}

.login-container { 
  display: flex; 
  justify-content: center; 
  align-items: center; 
  padding: 3rem 2rem; 
  min-height: calc(100vh - 260px); 
}

.login-form { 
  background: rgba(26, 26, 46, 0.8); 
  border-radius: 16px; 
  padding: 3rem; 
  width: 100%; 
  max-width: 480px; 
  box-shadow: 0 10px 30px rgba(0, 249, 255, 0.2); 
  border: 1px solid rgba(0, 249, 255, 0.15); 
  backdrop-filter: blur(10px); 
}

.form-heading { 
  text-align: center; 
  margin-bottom: 2rem; 
}

.form-heading h2 { 
  font-size: 2.1rem; 
  font-weight: 700; 
  background: linear-gradient(90deg, var(--primary), var(--secondary)); 
  -webkit-background-clip: text; 
  background-clip: text; 
  color: transparent; 
}

.form-group { 
  margin-bottom: 1.25rem; 
}

.form-group label { 
  display: block; 
  margin-bottom: 0.6rem; 
  color: var(--light); 
  font-weight: 500; 
}

.form-control { 
  width: 100%; 
  padding: 1rem; 
  border-radius: 8px; 
  border: 1px solid rgba(255,255,255,0.15); 
  background: rgba(255,255,255,0.06); 
  color: var(--light); 
  font-size: 1rem; 
  transition: all 0.2s; 
}

.form-control:focus { 
  outline: none; 
  border-color: var(--primary); 
  box-shadow: 0 0 0 2px rgba(0, 249, 255, 0.15); 
}

.btn-primary { 
  width: 100%; 
  padding: 1rem; 
  border-radius: 8px; 
  border: none; 
  background: linear-gradient(45deg, var(--primary), var(--secondary)); 
  color: #fff; 
  font-weight: 600; 
  cursor: pointer; 
  box-shadow: 0 4px 15px rgba(0, 249, 255, 0.25); 
}

.aux { 
  display: flex; 
  justify-content: space-between; 
  align-items: center; 
  margin-top: 0.75rem; 
  font-size: 0.9rem; 
}

.aux a { 
  color: var(--primary); 
  text-decoration: none; 
}

.alert { 
  text-align: center; 
  border-radius: 8px; 
  padding: 0.9rem 1rem; 
  margin-bottom: 1rem; 
}

.alert-error { 
  background: rgba(255, 42, 109, 0.12); 
  color: #ff2a6d; 
  border: 1px solid rgba(255, 42, 109, 0.25); 
}

footer { 
  text-align: center; 
  padding: 2rem; 
  color: var(--light); 
}

@media (max-width: 768px) { 
  .login-form { padding: 2rem; } 
  .page-heading { padding-top: 5rem; } 
}
  </style>
</head>
<body>

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
            <a href="signup.php">Signup</a>
            <a href="login.php" class="active">Login In</a>
        <?php endif; ?>
      </nav>
  </header>

  <div class="page-heading">
    <h3>LOGIN</h3>
    <div class="breadcrumb">
      <a href="index.php">Home</a> > Login
    </div>
  </div>

  <div class="login-container">
    <div class="login-form">
      <div class="form-heading">
        <h2>Welcome back</h2>
      </div>
      <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <form method="POST" action="loginprocess.php" novalidate>
        <div class="form-group">
          <label for="email">EMAIL</label>
          <input type="text" class="form-control" id="email" name="username" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <label for="password">PASSWORD</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Login</button>
        <div class="aux">
          <span>New here? <a href="signup.php">Create account</a></span>
        </div>
      </form>
    </div>
  </div>

  <footer>
    <p>© 2025 NEON BLADE. All Rights Reserved.</p>
  </footer>
  <script>
    // Profile Dropdown
    function toggleDropdown() {
      document.getElementById('dropdown-menu').classList.toggle('show');
    }

    // Close dropdown if clicking outside
    window.onclick = function(event) {
      if (!event.target.matches('#profile-pic')) {
        var dropdowns = document.getElementsByClassName("dropdown-menu");
        for (var i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>
</body>
</html>