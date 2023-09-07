DROP TABLE IF EXISTS `SISCourseMergeLog`;

CREATE TABLE `SISCourseMergeLog` (
  `BatchId` VARCHAR(16) NOT NULL,
  `JobType` VARCHAR(32) NOT NULL,
  `Status` VARCHAR(32) NOT NULL,
  `OriginalTargetOrgUnitId` BIGINT NOT NULL,
  `OriginalSourceOrgUnitId` BIGINT NOT NULL,
  `SourceSystemId` BIGINT NOT NULL,
  `NumberOfCoursesInBatch` INT DEFAULT NULL,
  `UserId` BIGINT NOT NULL,
  `ErrorType` VARCHAR(48) DEFAULT NULL,
  `Timestamp` DATETIME NOT NULL,
  UNIQUE KEY (`BatchId`, `OriginalSourceOrgUnitId`, `Timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
