DROP TABLE IF EXISTS `OrganizationalUnitDescendant_LOAD`;

CREATE TABLE `OrganizationalUnitDescendant_LOAD` (
  `OrgUnitId` INT NOT NULL,
  `DescendantOrgUnitId` INT NOT NULL,
  UNIQUE KEY (`OrgUnitId`, `DescendantOrgUnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
