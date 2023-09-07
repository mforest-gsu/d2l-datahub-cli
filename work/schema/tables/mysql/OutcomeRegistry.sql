DROP TABLE IF EXISTS `OutcomeRegistry`;

CREATE TABLE `OutcomeRegistry` (
  `OutcomeId` VARCHAR(16) NOT NULL,
  `RegistryId` VARCHAR(16) NOT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  UNIQUE KEY (`OutcomeId`, `RegistryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
