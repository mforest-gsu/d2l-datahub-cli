DROP TABLE IF EXISTS `OrganizationalUnitRecentAccess`;

CREATE TABLE `OrganizationalUnitRecentAccess` (
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `LastAccessedDate` DATETIME DEFAULT NULL,
  UNIQUE KEY (`OrgUnitId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

