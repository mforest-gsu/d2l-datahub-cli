DROP TABLE IF EXISTS `JITProvisionedUserLog`;

CREATE TABLE `JITProvisionedUserLog` (
  `UserId` INT NOT NULL,
  `MappingField` VARCHAR(32) DEFAULT NULL,
  `MappingFieldValue` VARCHAR(270) DEFAULT NULL,
  `ProviderType` VARCHAR(32) DEFAULT NULL,
  `ProviderId` VARCHAR(1024) DEFAULT NULL,
  `RoleId` INT DEFAULT NULL,
  `Timestamp` DATETIME NOT NULL,
  `Action` VARCHAR(16) DEFAULT NULL,
  UNIQUE KEY (`UserId`, `Timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
