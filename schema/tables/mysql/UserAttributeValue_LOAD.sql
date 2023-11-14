DROP TABLE IF EXISTS `UserAttributeValue_LOAD`;

CREATE TABLE `UserAttributeValue_LOAD` (
  `UserId` INT NOT NULL,
  `AttributeId` VARCHAR(128) NOT NULL,
  `Value` VARCHAR(4000) DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `ModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `Version` INT DEFAULT NULL,
  UNIQUE KEY (`UserId`, `AttributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
