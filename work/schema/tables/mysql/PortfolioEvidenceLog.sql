DROP TABLE IF EXISTS `PortfolioEvidenceLog`;

CREATE TABLE `PortfolioEvidenceLog` (
  `LogId` VARCHAR(16) NOT NULL,
  `ParentObjectId` VARCHAR(16) DEFAULT NULL,
  `ObjectId` VARCHAR(16) NOT NULL,
  `ObjectType` VARCHAR(40) NOT NULL,
  `UserId` INT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `Action` VARCHAR(16) NOT NULL,
  `IsMobile` TINYINT NOT NULL,
  `ActionDate` DATETIME NOT NULL,
  UNIQUE KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
