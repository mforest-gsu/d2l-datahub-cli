DROP TABLE IF EXISTS `UserAttributeValue`;

CREATE TABLE `UserAttributeValue` (
  `UserId` INT NOT NULL,
  `AttributeId` VARCHAR(128) NOT NULL,
  `Value` VARCHAR(4000) NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `ModifiedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `Version` INT NOT NULL,
  UNIQUE KEY (`UserId`, `AttributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
