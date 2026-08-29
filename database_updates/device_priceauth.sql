-- Device lower-price authorization table
-- Compatible with MySQL and MariaDB, including AWS Ubuntu MariaDB.
-- Relationships match the current inventory_db schema.

CREATE TABLE IF NOT EXISTS `device_price_authorization_requests` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `sale_id` INT NOT NULL,
    `serial_number` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `requested_by` INT NOT NULL,

    `set_price` DECIMAL(12,2) NOT NULL,
    `requested_price` DECIMAL(12,2) NOT NULL,

    `status` ENUM('pending','approved','rejected','used')
        NOT NULL DEFAULT 'pending',

    `reviewed_by` INT DEFAULT NULL,
    `reviewed_at` DATETIME DEFAULT NULL,

    `used_by` INT DEFAULT NULL,
    `used_at` DATETIME DEFAULT NULL,

    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),

    KEY `idx_price_auth_sale_id` (`sale_id`),
    KEY `idx_price_auth_serial` (`serial_number`),
    KEY `idx_price_auth_requested_by` (`requested_by`),
    KEY `idx_price_auth_reviewed_by` (`reviewed_by`),
    KEY `idx_price_auth_used_by` (`used_by`),
    KEY `idx_price_auth_status` (`status`),
    KEY `idx_price_auth_lookup` (`sale_id`,`serial_number`,`requested_price`,`status`),

    CONSTRAINT `fk_price_auth_sale`
        FOREIGN KEY (`sale_id`)
        REFERENCES `sales` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT `fk_price_auth_device`
        FOREIGN KEY (`serial_number`)
        REFERENCES `devices` (`serial_number`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT `fk_price_auth_requested_by`
        FOREIGN KEY (`requested_by`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT `fk_price_auth_reviewed_by`
        FOREIGN KEY (`reviewed_by`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    CONSTRAINT `fk_price_auth_used_by`
        FOREIGN KEY (`used_by`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL

) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
