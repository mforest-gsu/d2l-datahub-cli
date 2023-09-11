DROP TABLE IF EXISTS `OutcomeScaleDefinition`;

CREATE TABLE `OutcomeScaleDefinition` (
  `ScaleId` VARCHAR(16) NOT NULL,
  `Name` VARCHAR(1000) DEFAULT NULL,
  `IsDefault` TINYINT DEFAULT NULL,
  `UsePercentages` TINYINT DEFAULT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `RegistryId` VARCHAR(16) DEFAULT NULL,
  UNIQUE KEY (`ScaleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

