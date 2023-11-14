DROP TABLE IF EXISTS `GradeObjectLog`;

CREATE TABLE `GradeObjectLog` (
  `LogId` BIGINT NOT NULL,
  `Name` VARCHAR(50) DEFAULT NULL,
  `GradeObjectId` INT DEFAULT NULL,
  `UserId` INT DEFAULT NULL,
  `GradeSymbolString` VARCHAR(50) DEFAULT NULL,
  `PointsDenominator` DECIMAL(19, 9) DEFAULT NULL,
  `PointsNumerator` DECIMAL(19, 9) DEFAULT NULL,
  `WeightedDenominator` DECIMAL(19, 9) DEFAULT NULL,
  `WeightedNumerator` DECIMAL(19, 9) DEFAULT NULL,
  `Modified` DATETIME DEFAULT NULL,
  `ModifiedBy` INT DEFAULT NULL,
  UNIQUE KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
