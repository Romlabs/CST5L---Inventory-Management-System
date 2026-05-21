-- Create database
--CREATE DATABASE IF NOT EXISTS inventory_db;
--USE inventory_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    quantity INT NOT NULL DEFAULT 0,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample product data
INSERT INTO products (name, description, quantity, price) VALUES
('Laptop', 'High-performance laptop', 10, 799.99),
('Mouse', 'Wireless mouse', 50, 19.99),
('Keyboard', 'Mechanical keyboard', 30, 49.99),
('Monitor', '24-inch LED monitor', 15, 149.99);

-- Sample user (password = "password123")
INSERT INTO users (username, email, password) VALUES
('admin', 'admin@example.com', '$2y$10$YourHashedPasswordHere');
-- Note: Use registration page to create real users; this is just a placeholder.
