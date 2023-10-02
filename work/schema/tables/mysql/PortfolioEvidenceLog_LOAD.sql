DROP TABLE IF EXISTS `PortfolioEvidenceLog_LOAD`;

CREATE TABLE `PortfolioEvidenceLog_LOAD` (
  `LogId` VARCHAR(16) NOT NULL,
  `ParentObjectId` VARCHAR(16) DEFAULT NULL,
  `ObjectId` VARCHAR(16) DEFAULT NULL,
  `ObjectType` VARCHAR(40) DEFAULT NULL,
  `UserId` INT DEFAULT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `Action` VARCHAR(16) DEFAULT NULL,
  `IsMobile` TINYINT DEFAULT NULL,
  `ActionDate` DATETIME DEFAULT NULL,
  UNIQUE KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;