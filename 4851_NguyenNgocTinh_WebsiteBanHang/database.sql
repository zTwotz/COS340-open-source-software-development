-- MySQL Database Schema & Seed Script for NTECH STORE
-- Database: my_store
-- Author: Nguyễn Ngọc Tính - 4851

CREATE DATABASE IF NOT EXISTS my_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE my_store;

-- 1. Create Category Table
CREATE TABLE IF NOT EXISTS category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Create Product Table
CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Seed Category Data
INSERT INTO category (id, name, description) VALUES
(1, 'Điện thoại', 'Các dòng điện thoại thông minh iOS và Android chính hãng mới nhất'),
(2, 'Laptop', 'Máy tính xách tay văn phòng, gaming, đồ họa cao cấp'),
(3, 'Phụ kiện', 'Cáp sạc, tai nghe, chuột, bàn phím và thiết bị phụ trợ'),
(4, 'Máy tính bảng', 'iPad và các mẫu tablet cấu hình cao, màn hình rộng')
ON DUPLICATE KEY UPDATE name=VALUES(name), description=VALUES(description);

-- 4. Seed Product Data
INSERT INTO product (id, name, description, price, image, category_id) VALUES
(1, 'iPhone 15 Pro Max 256GB Titanium', 'Thiết kế khung viền titan siêu bền nhẹ, chip A17 Pro đột phá hiệu năng, camera zoom quang học 5x cực đỉnh.', 34990000.00, NULL, 1),
(2, 'Macbook Air M2 13.6 inch 8GB/256GB', 'Mỏng nhẹ tinh tế sang trọng, chip Apple M2 mạnh mẽ, màn hình Liquid Retina sống động, pin tối đa 18 tiếng liên tục.', 26490000.00, NULL, 2),
(3, 'Tai nghe AirPods Pro Gen 2 USB-C', 'Chức năng chống ồn chủ động (ANC) thế hệ mới, âm thanh vòm cá nhân hóa, kháng nước IP54.', 5890000.00, NULL, 3),
(4, 'iPad Air 5 M1 Wifi 64GB', 'Trang bị chip Apple M1 tối tân, hỗ trợ Apple Pencil 2 và Magic Keyboard, màn hình 10.9 inch hiển thị rực rỡ.', 15490000.00, NULL, 4)
ON DUPLICATE KEY UPDATE name=VALUES(name), description=VALUES(description), price=VALUES(price), category_id=VALUES(category_id);

-- 5. Create Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Create Order Details Table
CREATE TABLE IF NOT EXISTS order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Create Account Table
CREATE TABLE IF NOT EXISTS account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    fullname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
