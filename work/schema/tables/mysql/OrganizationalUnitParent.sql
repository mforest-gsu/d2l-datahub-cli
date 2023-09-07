DROP TABLE IF EXISTS `OrganizationalUnitParent`;

CREATE TABLE `OrganizationalUnitParent` (
  `OrgUnitId` INT NOT NULL,
  `ParentOrgUnitId` INT NOT NULL,
  `RowVersion` BIGINT NOT NULL,
  `DateDeleted` DATETIME DEFAULT NULL,
  UNIQUE KEY (`OrgUnitId`, `ParentOrgUnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
