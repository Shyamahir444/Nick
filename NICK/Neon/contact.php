<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us | NEON BLADE</title>
    <base href="/NICK/Neon/">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #ff2a6d;
            --primary-light: rgba(46, 204, 113, 0.8);
            --secondary: #0d0221;
            --dark: #0d0221;
            --light: #ffffff;
            --accent: #f6019d;
            --gray: #ebf6f4;
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
            backdrop-filter: blur(10px);
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
            color: var(--primary);
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .nav-links a.active {
            color: var(--primary);
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
        
        .breadcrumb {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--light);
        }
        
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: var(--light);
        }
        
        /* Contact Section */
        .contact-section {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }
        
        .contact-info {
            background: rgba(41, 44, 41, 0.7);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid var(--primary);
        }
        
        .contact-info h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 1rem;
        }
        
        .contact-info h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
        }
        
        .contact-info p {
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .contact-details {
            list-style: none;
        }
        
        .contact-details li {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .contact-details i {
            color: var(--primary);
            font-size: 1.2rem;
            margin-top: 0.2rem;
        }
        
        .contact-details span {
            font-weight: 600;
            color: var(--primary);
            display: inline-block;
            min-width: 80px;
        }
        
        .contact-form {
            background: rgba(41, 44, 41, 0.7);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid var(--primary);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-row {
            display: flex;
            gap: 1.5rem;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .form-control {
            width: 100%;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--light);
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(46, 204, 113, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .submit-btn {
            width: 100%;
            padding: 1rem;
            border-radius: 8px;
            border: none;
            background: var(--primary);
            color: var(--light);
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        
        .submit-btn:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
        }
        .error-message {
            color: var(--primary); /* Using primary color for errors */
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        /* Footer */
        footer {
            margin-top: 150px;
            background-color: rgb(41, 44, 41);
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
                background: rgba(41, 44, 41, 0.95);
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
            
            .form-row {
                flex-direction: column;
                gap: 1rem;
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
            
            .contact-section {
                padding: 2rem 1rem;
            }
        }
    </style>
</head>

<body>
    <video autoplay muted loop id="video-background">
        <source src="assets/images/goku.mp4" type="video/mp4">
    </video>

    <header class="header-area">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <img src="assets/images/logo1.png" alt="NEON BLADE Logo">
            </a>
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <a href="shop.php">Our Shop</a>
                <a href="contact.php" class="active">Contact Us</a>
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
        <h3>CONTACT US</h3>
        <div class="breadcrumb">
            <a href="index.php">Home</a> > Contact Us
        </div>
    </div>

    <div class="contact-section">
        <div class="contact-info">
            <h2>Say Hello!</h2>
            <p>Have questions or feedback? We'd love to hear from you. Reach out to us through any of the channels below.</p>
            <ul class="contact-details">
                <li>
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Address:</span> rajkot, 364720, INDIA
                </li>
                <li>
                    <i class="fas fa-phone"></i>
                    <span>Phone:</span> +91 99040011201
                </li>
                <li>
                    <i class="fas fa-phone"></i>
                    <span>Phone:</span> +91 9313815795
                </li>
                <li>
                    <i class="fas fa-envelope"></i>
                    <span>Email:</span> shyam44@rku.ac.in
                </li>
                <li>
                    <i class="fas fa-envelope"></i>
                    <span>Email:</span> mgauswami@rku.ac.in
                </li>
                <li>
                    <i class="fas fa-envelope"></i>
                    <span>Email:</span> ashish63@rku.ac.in
                </li>
            </ul>
        </div>

        <div class="contact-form">
            <form id="contact-form" action="" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                        <div class="error-message" id="nameError"></div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="surname" id="surname" placeholder="Your Surname">
                        <div class="error-message" id="surnameError"></div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
                    <div class="error-message" id="emailError"></div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                    <div class="error-message" id="subjectError"></div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="message" id="message" placeholder="Your Message"></textarea>
                    <div class="error-message" id="messageError"></div>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
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

        // Form submission handler
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;

            const nameInput = document.getElementById('name');
            const surnameInput = document.getElementById('surname');
            const emailInput = document.getElementById('email');
            const subjectInput = document.getElementById('subject');
            const messageInput = document.getElementById('message');

            const nameError = document.getElementById('nameError');
            const surnameError = document.getElementById('surnameError');
            const emailError = document.getElementById('emailError');
            const subjectError = document.getElementById('subjectError');
            const messageError = document.getElementById('messageError');

            // Clear previous errors
            nameError.textContent = '';
            surnameError.textContent = '';
            emailError.textContent = '';
            subjectError.textContent = '';
            messageError.textContent = '';

            // Validate Name
            if (nameInput.value.trim() === '') {
                nameError.textContent = 'Please enter your name.';
                isValid = false;
            }

            // Validate Surname
            if (surnameInput.value.trim() === '') {
                surnameError.textContent = 'Please enter your surname.';
                isValid = false;
            }

            // Validate Email
            if (emailInput.value.trim() === '') {
                emailError.textContent = 'Please enter your email address.';
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                emailError.textContent = 'Please enter a valid email address.';
                isValid = false;
            }

            // Validate Subject (optional, but good to show how to validate if it were required)
            // if (subjectInput.value.trim() === '') {
            //     subjectError.textContent = 'Please enter a subject.';
            //     isValid = false;
            // }

            // Validate Message
            if (messageInput.value.trim() === '') {
                messageError.textContent = 'Please enter your message.';
                isValid = false;
            }

            if (isValid) {
                // If all validation passes, you can now submit the form via AJAX or allow default submission
                alert('Thank you for your message! We will get back to you soon.');
                this.submit(); // Or use fetch API to send data
            }
        });
    </script>
</body>

</html>