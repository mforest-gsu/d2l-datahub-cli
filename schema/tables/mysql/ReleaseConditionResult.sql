DROP TABLE IF EXISTS `ReleaseConditionResult`;

CREATE TABLE `ReleaseConditionResult` (
  `ResultId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `Met` VARCHAR(7) DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`ResultId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
