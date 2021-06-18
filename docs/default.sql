CREATE DATABASE IF NOT EXISTS codeigniter_websystem;

USE codeigniter_websystem;

DROP TABLE IF EXISTS orders_products;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
	id int NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(300) NOT NULL,
    fullName VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    isAdmin BOOLEAN DEFAULT FALSE,
    hasSystemAccess BOOLEAN DEFAULT TRUE,
    isProvider BOOLEAN DEFAULT FALSE,
    active BOOLEAN DEFAULT TRUE,
    createdAt DATETIME DEFAULT current_timestamp,
    updatedAt DATETIME DEFAULT current_timestamp,
    PRIMARY KEY (id)
);

CREATE TABLE addresses (
	id int NOT NULL AUTO_INCREMENT,
    userId INT NOT NULL,
    addressOrdenation INT NOT NULL,
    zipCode VARCHAR(8) NOT NULL,
    address VARCHAR(100) NOT NULL,
    number VARCHAR(50) NOT NULL,
    complement VARCHAR(200),
    neighborhood VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(2) NOT NULL,
    country VARCHAR(100) NOT NULL,
    active BOOLEAN DEFAULT TRUE,
    createdAt DATETIME DEFAULT current_timestamp,
    updatedAt DATETIME DEFAULT current_timestamp,
    PRIMARY KEY (id),
    FOREIGN KEY (userId) REFERENCES users(id)
);

CREATE TABLE products (
	id int NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(500),
    active BOOLEAN DEFAULT TRUE,
    createdAt DATETIME DEFAULT current_timestamp,
    updatedAt DATETIME DEFAULT current_timestamp,
    PRIMARY KEY (id)
);

CREATE TABLE orders (
	id int NOT NULL AUTO_INCREMENT,
    providerId INT NOT NULL,
    contributorId INT NOT NULL,
    observations VARCHAR(500),
    finished BOOLEAN DEFAULT FALSE,
    createdAt DATETIME DEFAULT current_timestamp,
    updatedAt DATETIME DEFAULT current_timestamp,
    PRIMARY KEY (id),
    FOREIGN KEY (providerId) REFERENCES users(id),
    FOREIGN KEY (contributorId) REFERENCES users(id)
);

CREATE TABLE orders_products (
	id int NOT NULL AUTO_INCREMENT,
    orderId INT NOT NULL,
    productId INT NOT NULL,
    quantity INT NOT NULL,
    unitPrice INT NOT NULL,
    createdAt DATETIME DEFAULT current_timestamp,
    updatedAt DATETIME DEFAULT current_timestamp,
    PRIMARY KEY (id),
    FOREIGN KEY (orderId) REFERENCES orders(id),
    FOREIGN KEY (productId) REFERENCES products(id)
);