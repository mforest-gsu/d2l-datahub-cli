DROP TABLE IF EXISTS `PortfolioEvidenceObject`;

CREATE TABLE `PortfolioEvidenceObject` (
  `EvidenceId` VARCHAR(16) NOT NULL,
  `OwnerId` INT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `EvidenceType` VARCHAR(30) NOT NULL,
  `Title` VARCHAR(1000) NOT NULL,
  `IsApproved` TINYINT NOT NULL,
  `IsSpotlighted` TINYINT NOT NULL,
  `IsSharedToParents` TINYINT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `IsRecoverableByInstructor` TINYINT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `IsSharedWithInstructor` TINYINT DEFAULT NULL,
  `DateSharedWithInstructor` DATETIME DEFAULT NULL,
  UNIQUE KEY (`EvidenceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
