DROP TABLE IF EXISTS `UserAttributeDefinition`;

CREATE TABLE `UserAttributeDefinition` (
  `AttributeId` VARCHAR(128) NOT NULL,
  `Name` VARCHAR(128) DEFAULT NULL,
  `Type` VARCHAR(8) DEFAULT NULL,
  `AllowMultiple` TINYINT DEFAULT NULL,
  `IsDefault` TINYINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `ModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`AttributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

