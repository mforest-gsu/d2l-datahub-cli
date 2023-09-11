DROP TABLE IF EXISTS `GradebookSetting`;

CREATE TABLE `GradebookSetting` (
  `OrgUnitId` INT NOT NULL,
  `GradeSchemeId` BIGINT NOT NULL,
  `GradingSystem` VARCHAR(8) DEFAULT NULL,
  `UngradedItems` VARCHAR(25) DEFAULT NULL,
  `IsAdjustedFinalGradeReleased` TINYINT DEFAULT NULL,
  `IsCalculatedFinalGradeReleased` TINYINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`OrgUnitId`, `GradeSchemeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

