CREATE DATABASE webshop;
USE webshop;

--Products tabelle 
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Benutzer Tabelle
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--Bestellungen Tabelle 
CREATE TABLE oders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMp,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

--Bestell Details
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

--BEISPIEL PRODUKTE HINZUFÜGEN
INSERT INTO products (name, description, price, stock, image)
VALUES
('Laptop', 'High End Gaming Laptop' 1499.99, 10, 'laptop.jpg'),
('Maus', 'Wireless Gaming Mouse' 59,99, 50 'maus.jpg'),
('Monitor', '27 Zoll Monitor' 299,99, 20 'monitor.jpg'),
('Headset', 'Wireless Gaming-Headset', 129.99, 20, 'headset.jpg');

--BEISPIEL BESTELLUNGEN 
INSERT INTO orders (user_id, total_price, status) VALUES
(2, 1559,98, 'pending'),
