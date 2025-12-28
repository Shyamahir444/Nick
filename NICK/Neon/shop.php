<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Gaming Shop | NEON BLADE</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #ff2a6d;
            --primary-light: rgba(9, 242, 164, 0.47);
            --secondary: #0d0221;
            --dark: #0d0221;
            --light: #ffffff;
            --accent: #f6019d;
            --gray: #ebf6f4;
            --success: #2ecc71;
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
            line-height: 1.6;
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
        
        /* Header */
        .header-area {
            background: rgba(13, 2, 33, 0.9);
            border-radius: 0 0 150px 150px;
            height: 80px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.5s ease;
            z-index: 1000;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            height: 100%;
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
            font-size: 1rem;
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
            color: var(--secondary);
            font-weight: 600;
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

        .menu-trigger {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--light);
            z-index: 1001;
        }
        
        /* Page Heading */
        .page-heading {
            padding: 8rem 2rem 2rem;
            text-align: center;
        }
        
        .page-heading h3 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--light);
            text-transform: uppercase;
        }
        
        /* Shop Section */
        .shop-section {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .game-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .game-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
            border-color: var(--primary);
        }
        
        .game-image {
            height: 200px;
            overflow: hidden;
        }
        
        .game-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .game-card:hover .game-image img {
            transform: scale(1.1);
        }
        
        .game-info {
            padding: 1.5rem;
        }
        
        .game-category {
            display: inline-block;
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }
        
        .game-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--light);
        }
        
        .game-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .price {
            font-weight: 700;
            color: var(--primary);
        }
        
        .add-to-cart {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .add-to-cart:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(9, 242, 164, 0.5);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
            list-style: none;
        }
        
        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: var(--light);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .pagination a:hover, .pagination a.is_active {
            background: var(--primary);
            color: var(--secondary);
        }
        
        /* Footer */
        footer {
            margin-top: 150px;
            background-color: var(--primary-light);
            min-height: 120px;
            border-radius: 150px 150px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--light);
            text-align: center;
            padding: 2rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-area {
                border-radius: 0 0 50px 50px;
            }
            
            .nav-links {
                position: fixed;
                top: 80px;
                right: -100%;
                width: 70%;
                height: calc(100vh - 80px);
                background: var(--primary-light);
                flex-direction: column;
                justify-content: flex-start;
                padding: 2rem;
                gap: 1.5rem;
                transition: right 0.3s;
            }
            
            .nav-links.active {
                right: 0;
            }
            
            .menu-trigger {
                display: block;
            }
            
            .games-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            footer {
                border-radius: 50px 50px 0 0;
            }
        }
        
        @media (max-width: 480px) {
            .page-heading {
                padding-top: 6rem;
            }
            
            .page-heading h3 {
                font-size: 2rem;
            }
            
            .games-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <video autoplay muted loop id="video-background">
        <source src="assets/images/hog.mp4" type="video/mp4">
    </video>

    <header class="header-area">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <img src="assets/images/logo1.png" alt="NEON BLADE Logo">
            </a>
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <a href="shop.php" class="active">Our Shop</a>
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

    <div class="page-heading">
        <h3>OUR SHOP</h3>
    </div>

    <div class="shop-section">
        <?php
            $conn = getDBConnection();
            // Get the search keyword from the URL, if it exists
            $searchKeyword = trim($_GET['searchKeyword'] ?? '');

            // Base SQL query
            $sql = "SELECT id, title, category, price, image_path FROM products";
            $params = [];
            $types = '';

            // If a search keyword is provided, add a WHERE clause to filter results
            if (!empty($searchKeyword)) {
                $sql .= " WHERE title LIKE ? OR category LIKE ?";
                $searchTerm = "%" . $searchKeyword . "%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
                $types = 'ss';
            }

            $stmt = $conn->prepare($sql);

            // Bind parameters if they exist
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
        ?>
        <div class="games-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while($game = $result->fetch_assoc()): ?>
                <div class="game-card">
                    <div class="game-image">
                        <a href="product-details.php?id=<?php echo $game['id']; ?>"><img src="<?php echo htmlspecialchars($game['image_path']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>"></a>
                    </div>
                    <div class="game-info">
                        <span class="game-category"><?php echo htmlspecialchars($game['category']); ?></span>
                        <h4 class="game-title"><?php echo htmlspecialchars($game['title']); ?></h4>
                        <div class="game-price">
                            <span class="price">$<?php echo htmlspecialchars($game['price']); ?></span>
                            <a href="javascript:void(0);" onclick="addToCart(<?php echo $game['id']; ?>)" class="add-to-cart"><i class="fas fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center; font-size: 1.2rem;">No games found matching your search.</p>
            <?php endif; ?>
            <?php
                $stmt->close();
                $conn->close();
            ?>
        </div>
        
    </div>

    <footer>
        <p>© 2025 NEON BLADE. All Rights Reserved.</p>
    </footer>

    <script>
        // Toggle mobile menu
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');
        }

        // Profile Dropdown
        function toggleDropdown() {
          document.getElementById('dropdown-menu').classList.toggle('show');
        }
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