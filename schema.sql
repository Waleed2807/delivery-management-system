-- Database schema for the Delivery Management & Tracking System.
-- Import this before running the application:
--   mysql -u your_db_username -p your_db_name < schema.sql

CREATE TABLE IF NOT EXISTS delivery_users (
    userid   INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    usertype INT NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS delivery_point (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(150) NOT NULL,
    address_1  VARCHAR(150) NOT NULL,
    address_2  VARCHAR(150) DEFAULT NULL,
    postcode   VARCHAR(20)  NOT NULL,
    deliverer  INT NOT NULL,
    lat        DECIMAL(10, 7) NOT NULL,
    lng        DECIMAL(10, 7) NOT NULL,
    status     INT NOT NULL DEFAULT 0,
    del_photo  VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (deliverer) REFERENCES delivery_users(userid)
);
