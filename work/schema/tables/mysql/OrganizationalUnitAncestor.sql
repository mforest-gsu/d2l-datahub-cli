DROP TABLE IF EXISTS `OrganizationalUnitAncestor`;

CREATE TABLE `OrganizationalUnitAncestor` (
  `OrgUnitId` INT NOT NULL,
  `AncestorOrgUnitId` INT NOT NULL,
  UNIQUE KEY (`OrgUnitId`, `AncestorOrgUnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
