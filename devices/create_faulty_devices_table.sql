CREATE TABLE `faulty_devices` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `model` VARCHAR(500) NOT NULL,
    `serial_number` VARCHAR(255) NOT NULL,
    `cargo_number` VARCHAR(100) DEFAULT NULL,
    `issue` VARCHAR(500) DEFAULT NULL,
    `place` VARCHAR(255) DEFAULT NULL,
    `shop` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('Faulty','Repaired','Disposed') NOT NULL DEFAULT 'Faulty',
    `notes` TEXT DEFAULT NULL,
    `added_by` INT DEFAULT NULL,
    `date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_faulty_serial` (`serial_number`),
    KEY `idx_faulty_status` (`status`),
    KEY `idx_faulty_shop` (`shop`),
    KEY `idx_faulty_cargo` (`cargo_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
