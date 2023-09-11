DROP TABLE IF EXISTS `PortfolioEvidenceObject`;

CREATE TABLE `PortfolioEvidenceObject` (
  `EvidenceId` VARCHAR(16) NOT NULL,
  `OwnerId` INT DEFAULT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `EvidenceType` VARCHAR(30) DEFAULT NULL,
  `Title` VARCHAR(1000) DEFAULT NULL,
  `IsApproved` TINYINT DEFAULT NULL,
  `IsSpotlighted` TINYINT DEFAULT NULL,
  `IsSharedToParents` TINYINT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `IsRecoverableByInstructor` TINYINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsSharedWithInstructor` TINYINT DEFAULT NULL,
  `DateSharedWithInstructor` DATETIME DEFAULT NULL,
  UNIQUE KEY (`EvidenceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

