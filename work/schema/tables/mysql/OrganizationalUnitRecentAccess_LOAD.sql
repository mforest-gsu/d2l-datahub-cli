DROP TABLE IF EXISTS `OrganizationalUnitRecentAccess_LOAD`;

CREATE TABLE `OrganizationalUnitRecentAccess_LOAD` (
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `LastAccessedDate` DATETIME DEFAULT NULL,
  UNIQUE KEY (`OrgUnitId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
