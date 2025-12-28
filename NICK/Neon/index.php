<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NEON BLADE - Premium Gaming Experience</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    :root {
      --primary: #ff2a6d;
      --secondary: #05d9e8;
      --dark: #0d0221;
      --dark-alt: #1a1a2e;
      --light: #d1f7ff;
      --accent: #f6019d;
      --neon-blue: #00f9ff;
      --neon-pink: #ff2a6d;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      color: var(--light);
      background-color: var(--dark);
      line-height: 1.6;
      overflow-x: hidden;
    }
    
    /* Video Background */
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
    
    /* Header */
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
    
    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--secondary);
      transition: width 0.3s;
    }
    
    .nav-links a:hover::after {
      width: 100%;
    }
    
    .nav-links a.active {
      color: var(--primary);
    }
    
    .nav-links .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--secondary);
    }
    
    .user-menu {
      position: relative;
      display: flex;
      align-items: center;
    }

    .user-menu .profile-pic {
      cursor: pointer;
    }

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

    .dropdown-menu.show {
      display: block;
    }

    .dropdown-menu a {
      display: block;
      padding: 0.75rem 1.5rem;
      color: var(--light);
      text-decoration: none;
      transition: background-color 0.2s;
    }

    .dropdown-menu a:hover {
      background-color: var(--primary);
      color: white !important; /* Override other hover effects */
    }
    .menu-trigger {
      display: none;
      cursor: pointer;
      font-size: 1.5rem;
      color: var(--light);
      z-index: 1001;
    }
    
    /* Main Banner */
    .main-banner {
      padding: 6rem 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 80vh;
      position: relative;
      overflow: hidden;
    }
    
    .banner-content {
      display: flex;
      flex-wrap: wrap;
      width: 100%;
      max-width: 1400px;
      margin: 0 auto;
      gap: 3rem;
      align-items: center;
    }
    
    .text-content {
      flex: 1;
      min-width: 300px;
      animation: fadeInLeft 1s ease-out;
    }
    
    .text-content h6 {
      font-size: 1.2rem;
      color: var(--secondary);
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    
    .text-content h2 {
      font-family: 'Orbitron', sans-serif;
      font-size: 3.5rem;
      margin-bottom: 1.5rem;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      line-height: 1.2;
      text-transform: uppercase;
    }
    
    .text-content p {
      margin-bottom: 2rem;
      font-size: 1.1rem;
      color: rgba(255, 255, 255, 0.8);
      max-width: 600px;
    }
    
    .search-input {
      display: flex;
      gap: 1rem;
      max-width: 600px;
      margin-top: 2rem;
    }
    
    .search-input input {
      flex: 1;
      padding: 1rem;
      border-radius: 8px;
      border: none;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(5px);
      color: white;
      font-size: 1rem;
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s;
    }
    
    .search-input input:focus {
      outline: none;
      border-color: var(--secondary);
      background: rgba(5, 217, 232, 0.1);
    }
    
    .search-input input::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }
    
    .search-input button {
      padding: 0 2rem;
      background: linear-gradient(45deg, var(--primary), var(--accent));
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: transform 0.3s, box-shadow 0.3s;
      box-shadow: 0 4px 15px rgba(255, 42, 109, 0.4);
    }
    
    .search-input button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 42, 109, 0.6);
    }
    
    .image-content {
      flex: 1;
      min-width: 300px;
      position: relative;
      animation: fadeInRight 1s ease-out;
    }
    
    .image-content img {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
      transition: transform 0.5s;
    }
    
    .image-content:hover img {
      transform: scale(1.03);
    }
    
    .image-content .price,
    .image-content .offer {
      position: absolute;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      font-weight: bold;
      color: white;
      font-size: 1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    
    .image-content .price {
      top: 20px;
      left: 20px;
      background: linear-gradient(45deg, var(--primary), var(--accent));
    }
    
    .image-content .offer {
      top: 20px;
      right: 20px;
      background: linear-gradient(45deg, var(--secondary), var(--neon-blue));
    }
    
    /* Trending */
    .trending {
      padding: 5rem 2rem;
      background: rgba(10, 5, 30, 0.7);
      position: relative;
    }
    
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      flex-wrap: wrap;
      gap: 1rem;
      max-width: 1400px;
      margin: 0 auto 3rem;
    }
    
    .section-header h6 {
      font-size: 1.2rem;
      color: var(--secondary);
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    
    .section-header h2 {
      font-family: 'Orbitron', sans-serif;
      font-size: 2.5rem;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-transform: uppercase;
    }
    
    .view-all {
      color: var(--light);
      text-decoration: none;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: color 0.3s;
    }
    
    .view-all:hover {
      color: var(--secondary);
    }
    
    .trending-items {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 2rem;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .game-item {
      background: var(--dark-alt);
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
      position: relative;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .game-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
    }
    
    .game-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, transparent, rgba(255, 42, 109, 0.1), transparent);
      opacity: 0;
      transition: opacity 0.3s;
    }
    
    .game-item:hover::before {
      opacity: 1;
    }
    
    .game-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.5s;
    }
    
    .game-item:hover img {
      transform: scale(1.05);
    }
    
    .game-content {
      padding: 1.5rem;
    }
    
    .price {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 700;
      color: var(--secondary);
    }
    
    .price em {
      text-decoration: line-through;
      margin-right: 0.5rem;
      color: rgba(255, 255, 255, 0.5);
      font-weight: normal;
    }
    
    .details span {
      display: block;
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.7);
      margin-bottom: 0.5rem;
    }
    
    .details h4 {
      font-size: 1.2rem;
      margin: 0.5rem 0 1rem;
      color: white;
    }
    
    .details a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: linear-gradient(45deg, var(--primary), var(--accent));
      color: white;
      border-radius: 50%;
      text-decoration: none;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .details a:hover {
      transform: scale(1.1);
      box-shadow: 0 5px 15px rgba(255, 42, 109, 0.5);
    }
    
    /* CTA */
    .cta {
      padding: 5rem 2rem;
      text-align: center;
      background: linear-gradient(135deg, var(--dark-alt), var(--dark));
      position: relative;
      overflow: hidden;
    }
    
    .cta::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('assets/images/pattern.png') center/cover;
      opacity: 0.05;
    }
    
    .cta-box {
      max-width: 800px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }
    
    .cta-box h6 {
      font-size: 1.2rem;
      color: var(--secondary);
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 1rem;
    }
    
    .cta-box h2 {
      font-family: 'Orbitron', sans-serif;
      font-size: 2.5rem;
      margin-bottom: 2rem;
      line-height: 1.3;
    }
    
    .cta-box em {
      font-style: normal;
      color: var(--primary);
    }
    
    .newsletter {
      display: flex;
      justify-content: center;
      gap: 1rem;
      flex-wrap: wrap;
    }
    
    .newsletter input {
      padding: 1rem;
      border: none;
      border-radius: 8px;
      min-width: 300px;
      flex: 1;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(5px);
      color: white;
      font-size: 1rem;
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s;
    }
    
    .newsletter input:focus {
      outline: none;
      border-color: var(--secondary);
      background: rgba(5, 217, 232, 0.1);
    }
    
    .newsletter input::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }
    
    .newsletter button {
      padding: 1rem 2rem;
      border: none;
      border-radius: 8px;
      background: linear-gradient(45deg, var(--primary), var(--accent));
      color: white;
      cursor: pointer;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: transform 0.3s, box-shadow 0.3s;
      box-shadow: 0 4px 15px rgba(255, 42, 109, 0.4);
    }
    
    .newsletter button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 42, 109, 0.6);
    }
    
    /* Footer */
    footer {
      text-align: center;
      padding: 2rem;
      background: var(--dark);
      color: var(--light);
      font-size: 0.9rem;
      border-top: 1px solid rgba(5, 217, 232, 0.2);
    }
    
    footer p {
      margin-bottom: 0.5rem;
    }
    
    .social-links {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      margin: 1rem 0;
    }
    
    .social-links a {
      color: var(--light);
      font-size: 1.2rem;
      transition: color 0.3s, transform 0.3s;
    }
    
    .social-links a:hover {
      color: var(--secondary);
      transform: translateY(-3px);
    }
    
    .add-to-cart {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: linear-gradient(45deg, var(--primary), var(--accent));
        color: white;
        border-radius: 50%;
        text-decoration: none;
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        cursor: pointer;
    }

    .add-to-cart:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(255, 42, 109, 0.5);
    }


    /* Animations */
    @keyframes fadeInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    
    @keyframes fadeInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
      .text-content h2 {
        font-size: 2.8rem;
      }
    }
    
    @media (max-width: 768px) {
      .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        width: 70%;
        height: 100vh;
        background: var(--dark-alt);
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        transition: right 0.3s;
        z-index: 1000;
      }
      
      .nav-links.active {
        right: 0;
      }
      
      .menu-trigger {
        display: block;
      }
      
      .text-content h2 {
        font-size: 2.2rem;
      }
      
      .section-header h2 {
        font-size: 2rem;
      }
      
      .cta-box h2 {
        font-size: 2rem;
      }
    }
    
    @media (max-width: 480px) {
      .header-area {
        padding: 1rem;
      }
      
      .main-banner {
        padding: 4rem 1rem;
      }
      
      .text-content h2 {
        font-size: 1.8rem;
      }
      
      .search-input {
        flex-direction: column;
      }
      
      .search-input button {
        width: 100%;
      }
      
      .newsletter input {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>

  <video autoplay muted loop id="video-background">
    <source src="assets/images/bgvideogames.mp4" type="video/mp4" />
  </video>

  <header class="header-area">
    <div class="nav-container">
      <a href="index.php" class="logo">
        <img src="assets/images/logo1.png" alt="NEON BLADE Logo" />
      </a>
      <nav class="nav-links">
        <a href="index.php" class="active">Home</a>
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
            <a href="login.php">Login In</a>
        <?php endif; ?>
      </nav>
      <div class="menu-trigger" onclick="toggleMenu()">☰</div>
    </div>
  </header>

  <main>
    <section class="main-banner">
      <div class="banner-content">
        <div class="text-content">
          <h6>Welcome to NEON BLADE</h6>
          <h2>BEST GAMING SITE EVER!</h2>
          <p>Discover the latest and greatest games at unbeatable prices. Join our community of gamers and get exclusive deals.</p>
          <form class="search-input" action="shop.php" method="GET">
            <input type="text" placeholder="Search for games..." id="searchText" name="searchKeyword" />
            <button type="submit">Search Now</button>
          </form>
        </div>
        <div class="image-content">
          <img src="assets/images/sot.png" alt="Sea of Thieves" />
          <span class="price">$22</span>
          <span class="offer">-40%</span>
        </div>
      </div>
    </section>

    <section class="trending">
      <div class="section-header">
        <h6>Trending</h6>
        <h2>Trending Games</h2>
        <a href="shop.php" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="trending-items">
        <!-- Item 1 -->
        <div class="game-item">
          <a href="cart.php"><img src="assets/images/wolve.jpg" alt="Wolverine" /></a>
          <div class="game-content">
            <span class="price"><em>$28</em> $20</span>
            <div class="details">
              <span>Action | Story line</span>
              <h4>WOLVERINE</h4>
              <a href="javascript:void(0);" onclick="addtoCart(9)" class="addtocart"><i class="fas fa-shopping-bag"></i></a>
            </div>
          </div>
        </div>
        
        <!-- Item 2 -->
        <div class="game-item">
          <a href="spider.php"><img src="assets/images/spider.jpg" alt="Spider-Man" /></a>
          <div class="game-content">
            <span class="price">$44</span>
            <div class="details">
              <span>Action | Story line</span>
              <h4>Spider-Man: Miles Morales</h4>
              <a href="javascript:void(0);" onclick="addToCart(10)" class="add-to-cart"><i class="fas fa-shopping-bag"></i></a>
            </div>
          </div>
        </div>
        
        <!-- Item 3 -->
        <div class="game-item">
          <a href="valo.php"><img src="assets/images/valo.webp" alt="Valorant" /></a>
          <div class="game-content">
            <span class="price"><em>$64</em> $44</span>
            <div class="details">
              <span>Action | Multiplayer</span>
              <h4>VALORANT</h4>
              <a href="javascript:void(0);" onclick="addToCart(11)" class="add-to-cart"><i class="fas fa-shopping-bag"></i></a>
            </div>
          </div>
        </div>
        
        <!-- Item 4 -->
        <div class="game-item">
          <a href="fifa.php"><img src="assets/images/fifa.webp" alt="FIFA 24" /></a>
          <div class="game-content">
            <span class="price">$32</span>
            <div class="details">
              <span>Action | Open World</span>
              <h4>FIFA 2024</h4>
              <a href="javascript:void(0);" onclick="addToCart(12)" class="add-to-cart"><i class="fas fa-shopping-bag"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="cta">
      <div class="cta-box">
        <h6>NEWSLETTER</h6>
        <h2>Get Up To $100 Off Just By <em>Subscribing</em> To Our Newsletter!</h2>
        <form class="newsletter" action="#">
          <input type="email" placeholder="Your email..." required />
          <button type="submit">Subscribe Now</button>
        </form>
      </div>
    </section>
  </main>

  <footer>
    <div class="social-links">
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-discord"></i></a>
      <a href="#"><i class="fab fa-twitch"></i></a>
    </div>
    <p>© 2025 NEON BLADE. All Rights Reserved.</p>
    <p>Designed for gamers by gamers</p>
  </footer>

  <script>
    // Toggle mobile menu
    function toggleMenu() {
      const navLinks = document.querySelector('.nav-links');
      navLinks.classList.toggle('active');
    }
    
    // Close menu when clicking on a link
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        const navLinks = document.querySelector('.nav-links');
        navLinks.classList.remove('active');
      });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });

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

    function addToCart(productId) {
        const formData = new FormData();
        formData.append('action', 'add');
        formData.append('product_id', productId);

        fetch('cart_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Item added to cart!');
            } else {
                alert('Failed to add item to cart.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
  </script>
</body>
</html>