DROP TABLE IF EXISTS `SISCourseMergeLog_LOAD`;

CREATE TABLE `SISCourseMergeLog_LOAD` (
  `BatchId` VARCHAR(36) NOT NULL,
  `JobType` VARCHAR(32) DEFAULT NULL,
  `Status` VARCHAR(32) DEFAULT NULL,
  `OriginalTargetOrgUnitId` BIGINT DEFAULT NULL,
  `OriginalSourceOrgUnitId` BIGINT NOT NULL,
  `SourceSystemId` BIGINT DEFAULT NULL,
  `NumberOfCoursesInBatch` INT DEFAULT NULL,
  `UserId` BIGINT DEFAULT NULL,
  `ErrorType` VARCHAR(48) DEFAULT NULL,
  `Timestamp` DATETIME NOT NULL,
  UNIQUE KEY (`BatchId`, `OriginalSourceOrgUnitId`, `Timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
