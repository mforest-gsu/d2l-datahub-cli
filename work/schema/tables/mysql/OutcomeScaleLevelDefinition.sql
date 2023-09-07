DROP TABLE IF EXISTS `OutcomeScaleLevelDefinition`;

CREATE TABLE `OutcomeScaleLevelDefinition` (
  `ScaleLevelId` VARCHAR(16) NOT NULL,
  `ScaleId` VARCHAR(16) NOT NULL,
  `Name` VARCHAR(1000) NOT NULL,
  `SortOrder` INT NOT NULL,
  `PercentageRangeStart` INT DEFAULT NULL,
  `RGB` VARCHAR(40) NOT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  UNIQUE KEY (`ScaleLevelId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
