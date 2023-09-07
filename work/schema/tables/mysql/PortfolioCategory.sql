DROP TABLE IF EXISTS `PortfolioCategory`;

CREATE TABLE `PortfolioCategory` (
  `CategoryId` VARCHAR(16) NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `Name` VARCHAR(256) NOT NULL,
  `IsRetired` TINYINT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  UNIQUE KEY (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
