CREATE DATABASE IF NOT EXISTS pos_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE pos_db;

CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    avatar VARCHAR(255) NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    avatar VARCHAR(255) NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE customers
    MODIFY full_name VARCHAR(100) NOT NULL,
    MODIFY email VARCHAR(100) NOT NULL,
    MODIFY phone VARCHAR(20) NULL,
    MODIFY created_at DATETIME NOT NULL;

SET @add_user_password = IF(
    (SELECT COUNT(*) FROM information_schema.columns
     WHERE table_schema = DATABASE()
       AND table_name = 'users'
       AND column_name = 'password') = 0,
    'ALTER TABLE `users` ADD COLUMN `password` VARCHAR(255) NOT NULL DEFAULT ''$2y$10$/Jx2NbwXiJ/JZbXuhe0SKi.bKnGKje3lsW/7Egr/tBOd3rIROwoYEi''',
    'SELECT 1'
);
PREPARE add_user_password_stmt FROM @add_user_password;
EXECUTE add_user_password_stmt;
DEALLOCATE PREPARE add_user_password_stmt;

SET @add_user_admin = IF(
    (SELECT COUNT(*) FROM information_schema.columns
     WHERE table_schema = DATABASE()
       AND table_name = 'users'
       AND column_name = 'is_admin') = 0,
    'ALTER TABLE `users` ADD COLUMN `is_admin` TINYINT(1) NOT NULL DEFAULT 0',
    'SELECT 1'
);
PREPARE add_user_admin_stmt FROM @add_user_admin;
EXECUTE add_user_admin_stmt;
DEALLOCATE PREPARE add_user_admin_stmt;

SET @add_user_avatar = IF(
    (SELECT COUNT(*) FROM information_schema.columns
     WHERE table_schema = DATABASE()
       AND table_name = 'users'
       AND column_name = 'avatar') = 0,
    'ALTER TABLE `users` ADD COLUMN `avatar` VARCHAR(255) NULL',
    'SELECT 1'
);
PREPARE add_user_avatar_stmt FROM @add_user_avatar;
EXECUTE add_user_avatar_stmt;
DEALLOCATE PREPARE add_user_avatar_stmt;

SET @add_user_phone = IF(
    (SELECT COUNT(*) FROM information_schema.columns
     WHERE table_schema = DATABASE()
       AND table_name = 'users'
       AND column_name = 'phone') = 0,
    'ALTER TABLE `users` ADD COLUMN `phone` VARCHAR(20) NULL',
    'SELECT 1'
);
PREPARE add_user_phone_stmt FROM @add_user_phone;
EXECUTE add_user_phone_stmt;
DEALLOCATE PREPARE add_user_phone_stmt;

SET @add_customer_avatar = IF(
    (SELECT COUNT(*) FROM information_schema.columns
     WHERE table_schema = DATABASE()
       AND table_name = 'customers'
       AND column_name = 'avatar') = 0,
    'ALTER TABLE `customers` ADD COLUMN `avatar` VARCHAR(255) NULL',
    'SELECT 1'
);
PREPARE add_customer_avatar_stmt FROM @add_customer_avatar;
EXECUTE add_customer_avatar_stmt;
DEALLOCATE PREPARE add_customer_avatar_stmt;

UPDATE users
SET password = '$2y$10$/Jx2NbwXiJ/JZbXuhe0SKi.bKnGKje3lsW/7Egr/tBOd3rIROwoYEi'
WHERE password IS NULL OR password = '';

UPDATE users
SET is_admin = 1
WHERE username = 'Mr.D' OR full_name = 'George Siray';

ALTER TABLE users
    MODIFY username VARCHAR(50) NOT NULL,
    MODIFY full_name VARCHAR(100) NOT NULL,
    MODIFY password VARCHAR(255) NOT NULL,
    MODIFY is_admin TINYINT(1) NOT NULL DEFAULT 0,
    MODIFY created_at DATETIME NOT NULL;

SET @drop_customer_columns = IFNULL((
    SELECT CONCAT(
        'ALTER TABLE `customers` ',
        GROUP_CONCAT(CONCAT('DROP COLUMN `', column_name, '`') ORDER BY column_name SEPARATOR ', ')
    )
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'customers'
      AND column_name = 'updated_at'
), 'SELECT 1');
PREPARE drop_customer_columns_stmt FROM @drop_customer_columns;
EXECUTE drop_customer_columns_stmt;
DEALLOCATE PREPARE drop_customer_columns_stmt;

SET @drop_user_columns = IFNULL((
    SELECT CONCAT(
        'ALTER TABLE `users` ',
        GROUP_CONCAT(CONCAT('DROP COLUMN `', column_name, '`') ORDER BY column_name SEPARATOR ', ')
    )
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'users'
      AND column_name = 'updated_at'
), 'SELECT 1');
PREPARE drop_user_columns_stmt FROM @drop_user_columns;
EXECUTE drop_user_columns_stmt;
DEALLOCATE PREPARE drop_user_columns_stmt;

INSERT INTO customers (full_name, email, phone, created_at)
SELECT 'Avery Santos', 'avery.santos@example.com', '202-555-0101', '2026-10-01 09:00:00'
WHERE NOT EXISTS (SELECT 1 FROM customers WHERE email = 'avery.santos@example.com');

INSERT INTO customers (full_name, email, phone, created_at)
SELECT 'Jordan Reyes', 'jordan.reyes@example.com', '202-555-0102', '2026-10-02 09:00:00'
WHERE NOT EXISTS (SELECT 1 FROM customers WHERE email = 'jordan.reyes@example.com');

INSERT INTO customers (full_name, email, phone, created_at)
SELECT 'Morgan Cruz', 'morgan.cruz@example.com', '202-555-0103', '2026-10-03 09:00:00'
WHERE NOT EXISTS (SELECT 1 FROM customers WHERE email = 'morgan.cruz@example.com');

INSERT INTO customers (full_name, email, phone, created_at)
SELECT 'Casey Lim', 'casey.lim@example.com', '202-555-0104', '2026-10-04 09:00:00'
WHERE NOT EXISTS (SELECT 1 FROM customers WHERE email = 'casey.lim@example.com');

INSERT INTO customers (full_name, email, phone, created_at)
SELECT 'Taylor Garcia', 'taylor.garcia@example.com', '202-555-0105', '2026-10-05 09:00:00'
WHERE NOT EXISTS (SELECT 1 FROM customers WHERE email = 'taylor.garcia@example.com');

INSERT INTO users (username, full_name, password, created_at)
VALUES ('asantos', 'Avery Santos', '$2y$10$/Jx2NbwXiJ/JZbXuhe0SKi.bKnGKje3lsW/7Egr/tBOd3rIROwoYEi', '2026-10-01 09:00:00')
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), password = VALUES(password);

INSERT INTO users (username, full_name, password, created_at)
VALUES ('jreyes', 'Jordan Reyes', '$2y$10$/Jx2NbwXiJ/JZbXuhe0SKi.bKnGKje3lsW/7Egr/tBOd3rIROwoYEi', '2026-10-02 09:00:00')
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), password = VALUES(password);

INSERT INTO users (username, full_name, password, created_at)
VALUES ('mcruz', 'Morgan Cruz', '$2y$10$/Jx2NbwXiJ/JZbXuhe0SKi.bKnGKje3lsW/7Egr/tBOd3rIROwoYEi', '2026-10-03 09:00:00')
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), password = VALUES(password);

INSERT INTO users (username, full_name, password, created_at)
VALUES ('clim', 'Casey Lim', '$2y$10$/Jx2NbwXiJ/JZbXuhe0SKi.bKnGKje3lsW/7Egr/tBOd3rIROwoYEi', '2026-10-04 09:00:00')
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), password = VALUES(password);

INSERT INTO users (username, full_name, password, created_at)
VALUES ('tgarcia', 'Taylor Garcia', '$2y$10$/Jx2NbwXiJ/JZbXuhe0SKi.bKnGKje3lsW/7Egr/tBOd3rIROwoYEi', '2026-10-05 09:00:00')
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), password = VALUES(password);
