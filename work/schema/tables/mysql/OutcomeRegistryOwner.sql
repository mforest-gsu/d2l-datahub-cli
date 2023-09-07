DROP TABLE IF EXISTS `OutcomeRegistryOwner`;

CREATE TABLE `OutcomeRegistryOwner` (
  `OwnerType` INT NOT NULL,
  `OwnerId` VARCHAR(255) NOT NULL,
  `RegistryId` VARCHAR(16) NOT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  UNIQUE KEY (`OwnerType`, `OwnerId`, `RegistryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
