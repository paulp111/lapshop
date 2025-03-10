CREATE DATABASE webshop;
USE webshop;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, stock, image)
VALUES
('Laptop', 'High end gaming Laptop' 1299,99, 50 'laptop.jpg'),
('Maus', 'Wireless Mouse');