DROP TABLE IF EXISTS `OutcomeAlignedtoToolObject`;

CREATE TABLE `OutcomeAlignedtoToolObject` (
  `ObjectType` INT NOT NULL,
  `ObjectId` VARCHAR(255) NOT NULL,
  `OutcomeId` VARCHAR(16) NOT NULL,
  `RegistryId` VARCHAR(16) NOT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  UNIQUE KEY (`ObjectType`, `ObjectId`, `OutcomeId`, `RegistryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

