DROP TABLE IF EXISTS `OutcomeScaleLevelDefinition`;

CREATE TABLE `OutcomeScaleLevelDefinition` (
  `ScaleLevelId` VARCHAR(36) NOT NULL,
  `ScaleId` VARCHAR(36) DEFAULT NULL,
  `Name` VARCHAR(1000) DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `PercentageRangeStart` INT DEFAULT NULL,
  `RGB` VARCHAR(40) DEFAULT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  UNIQUE KEY (`ScaleLevelId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
