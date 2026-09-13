-- Run this migration ONLY if you already created the returns table using the first module.
ALTER TABLE `returns`
    ADD COLUMN `replacement_identifier` VARCHAR(255) NULL AFTER `notes`,
    ADD COLUMN `replacement_description` VARCHAR(255) NULL AFTER `replacement_identifier`,
    ADD COLUMN `replacement_price` DECIMAL(10,2) NULL AFTER `replacement_description`,
    ADD KEY `idx_returns_replacement_identifier` (`replacement_identifier`),
    MODIFY COLUMN `branch` ENUM('KIMATHI','MOI','WAREHOUSE') NULL;
