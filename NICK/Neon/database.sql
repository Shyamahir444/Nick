-- Create database
CREATE DATABASE IF NOT EXISTS neon_blade;
USE neon_blade;

-- Users table for signup/login
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Cart items table
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders table (for future checkout functionality)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample products
INSERT INTO products (title, price, category, image_path) VALUES
('Call of Duty Black Ops', 59.99, 'Action', 'assets/images/callofduty.jpg'),
('Sea of Thieves', 39.99, 'Adventure', 'assets/images/seaof.jpg'),
('Counter Strike', 14.99, 'FPS', 'assets/images/counter.jpg'),
('Forza Horizon 5', 59.99, 'Racing', 'assets/images/forza.jpg'),
('GTA V', 29.99, 'Action', 'assets/images/gta.jpg'),
('Ghost of Tsushima', 49.99, 'Adventure', 'assets/images/ghost.jpg'),
('Cyber Punk', 39.99, 'RPG', 'assets/images/cyber.webp'),
('The Last Of Us', 49.99, 'Adventure', 'assets/images/last.webp'),
('WOLVERINE', 20.00, 'Action', 'assets/images/wolve.jpg'),
('Spider-Man: Miles Morales', 44.00, 'Action', 'assets/images/spider.jpg'),
('VALORANT', 44.00, 'Action', 'assets/images/valo.webp'),
('FIFA 2024', 32.00, 'Action', 'assets/images/fifa.webp');
