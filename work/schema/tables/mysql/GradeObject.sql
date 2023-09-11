DROP TABLE IF EXISTS `GradeObject`;

CREATE TABLE `GradeObject` (
  `GradeObjectId` INT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `ParentGradeObjectId` INT DEFAULT NULL,
  `Name` VARCHAR(128) DEFAULT NULL,
  `TypeName` VARCHAR(50) DEFAULT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `IsAutoPointed` TINYINT DEFAULT NULL,
  `IsFormula` TINYINT DEFAULT NULL,
  `IsBonus` TINYINT DEFAULT NULL,
  `MaxPoints` DECIMAL(19, 9) DEFAULT NULL,
  `CanExceedMaxGrade` TINYINT DEFAULT NULL,
  `ExcludeFromFinalGradeCalc` TINYINT DEFAULT NULL,
  `GradeSchemeId` BIGINT DEFAULT NULL,
  `Weight` DECIMAL(19, 9) DEFAULT NULL,
  `NumLowestGradesToDrop` INT DEFAULT NULL,
  `NumHighestGradesToDrop` INT DEFAULT NULL,
  `WeightDistributionType` VARCHAR(8) DEFAULT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `ToolName` VARCHAR(50) DEFAULT NULL,
  `AssociatedToolItemId` BIGINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `ShortName` VARCHAR(128) DEFAULT NULL,
  `GradeObjectTypeId` INT DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `DeletedDate` DATETIME DEFAULT NULL,
  `DeletedByUserId` INT DEFAULT NULL,
  `ResultId` INT DEFAULT NULL,
  UNIQUE KEY (`GradeObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

