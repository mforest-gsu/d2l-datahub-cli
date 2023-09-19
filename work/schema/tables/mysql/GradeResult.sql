DROP TABLE IF EXISTS `GradeResult`;

CREATE TABLE `GradeResult` (
  `GradeObjectId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `PointsNumerator` DECIMAL(19, 9) DEFAULT NULL,
  `PointsDenominator` DECIMAL(19, 9) DEFAULT NULL,
  `WeightedNumerator` DECIMAL(19, 9) DEFAULT NULL,
  `WeightedDenominator` DECIMAL(19, 9) DEFAULT NULL,
  `IsReleased` TINYINT DEFAULT NULL,
  `IsDropped` TINYINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `Comments` VARCHAR(1000) DEFAULT NULL,
  `PrivateComments` VARCHAR(1000) DEFAULT NULL,
  `IsExempt` TINYINT DEFAULT NULL,
  `GradeText` VARCHAR(50) DEFAULT NULL,
  `GradeReleasedDate` DATETIME DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`GradeObjectId`, `OrgUnitId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
