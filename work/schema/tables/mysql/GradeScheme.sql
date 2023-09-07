DROP TABLE IF EXISTS `GradeScheme`;

CREATE TABLE `GradeScheme` (
  `GradeSchemeId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `SchemeName` VARCHAR(128) NOT NULL,
  `GradeSchemeRangeId` BIGINT NOT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `DeletedDate` DATETIME DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`GradeSchemeId`, `GradeSchemeRangeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
