DROP TABLE IF EXISTS `JITProvisionedUserLog`;

CREATE TABLE `JITProvisionedUserLog` (
  `UserId` INT NOT NULL,
  `MappingField` VARCHAR(32) NOT NULL,
  `MappingFieldValue` VARCHAR(270) NOT NULL,
  `ProviderType` VARCHAR(32) NOT NULL,
  `ProviderId` VARCHAR(1024) NOT NULL,
  `RoleId` INT NOT NULL,
  `Timestamp` DATETIME NOT NULL,
  `Action` VARCHAR(16) NOT NULL,
  UNIQUE KEY (`UserId`, `Timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
