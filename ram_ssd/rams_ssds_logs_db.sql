-- Update rams_ssds_logs to match the flexible RAM/SSD inventory structure.
-- Run once on the inventory_system database.

ALTER TABLE `rams_ssds_logs`
    MODIFY `type` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    MODIFY `storage` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    MODIFY `branch` ENUM('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

-- Existing numeric storage values are preserved as text.
-- New logs can store values such as:
-- type: DESKTOP RAM / DDR4 SODIMM / NVMe Gen4
-- storage: 8GB 3200MHz / 16GB DDR5 4800MHz / 512GB NVMe
-- branch: KIMATHI / MOI / NULL
