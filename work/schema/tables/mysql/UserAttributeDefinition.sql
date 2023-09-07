DROP TABLE IF EXISTS `UserAttributeDefinition`;

CREATE TABLE `UserAttributeDefinition` (
  `AttributeId` VARCHAR(128) NOT NULL,
  `Name` VARCHAR(128) NOT NULL,
  `Type` VARCHAR(8) NOT NULL,
  `AllowMultiple` TINYINT NOT NULL,
  `IsDefault` TINYINT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `ModifiedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`AttributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
