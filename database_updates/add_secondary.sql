-- Additive dual-storage support for devices.
-- Existing storage_type/storage_capacity remain the PRIMARY storage fields,
-- so existing pages and reports continue working without modification.

ALTER TABLE `devices`
    ADD COLUMN `secondary_storage_type` ENUM('SSD','HDD') NULL AFTER `storage_capacity`,
    ADD COLUMN `secondary_storage_capacity` INT NULL AFTER `secondary_storage_type`;
