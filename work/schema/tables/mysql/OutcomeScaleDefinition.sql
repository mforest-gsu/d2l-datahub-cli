DROP TABLE IF EXISTS `OutcomeScaleDefinition`;

CREATE TABLE `OutcomeScaleDefinition` (
  `ScaleId` VARCHAR(16) NOT NULL,
  `Name` VARCHAR(1000) NOT NULL,
  `IsDefault` TINYINT NOT NULL,
  `UsePercentages` TINYINT NOT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `RegistryId` VARCHAR(16) NOT NULL,
  UNIQUE KEY (`ScaleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
