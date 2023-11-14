DROP TABLE IF EXISTS `GradeSchemeRange`;

CREATE TABLE `GradeSchemeRange` (
  `GradeSchemeRangeId` BIGINT NOT NULL,
  `GradeSchemeId` BIGINT NOT NULL,
  `SymbolString` VARCHAR(100) DEFAULT NULL,
  `AssignedValue` DECIMAL(19, 9) DEFAULT NULL,
  `RangeStart` DECIMAL(19, 9) DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`GradeSchemeRangeId`, `GradeSchemeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
