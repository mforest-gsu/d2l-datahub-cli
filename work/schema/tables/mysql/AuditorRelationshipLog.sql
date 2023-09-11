DROP TABLE IF EXISTS `AuditorRelationshipLog`;

CREATE TABLE `AuditorRelationshipLog` (
  `AuditorId` INT NOT NULL,
  `UserToAuditId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `Action` VARCHAR(16) DEFAULT NULL,
  `ModifiedBy` INT DEFAULT NULL,
  `ModifiedDate` DATETIME NOT NULL,
  UNIQUE KEY (`AuditorId`, `UserToAuditId`, `OrgUnitId`, `ModifiedDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

