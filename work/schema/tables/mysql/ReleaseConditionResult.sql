DROP TABLE IF EXISTS `ReleaseConditionResult`;

CREATE TABLE `ReleaseConditionResult` (
  `ResultId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `Met` VARCHAR(7) NOT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`ResultId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
