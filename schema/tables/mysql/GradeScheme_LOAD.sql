DROP TABLE IF EXISTS `GradeScheme_LOAD`;

CREATE TABLE `GradeScheme_LOAD` (
  `GradeSchemeId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `SchemeName` VARCHAR(128) DEFAULT NULL,
  `GradeSchemeRangeId` BIGINT NOT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `DeletedDate` DATETIME DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`GradeSchemeId`, `GradeSchemeRangeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
