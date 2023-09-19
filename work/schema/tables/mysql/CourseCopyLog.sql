DROP TABLE IF EXISTS `CourseCopyLog`;

CREATE TABLE `CourseCopyLog` (
  `SourceOrgUnitId` INT DEFAULT NULL,
  `DestinationOrgUnitId` INT DEFAULT NULL,
  `UserId` BIGINT DEFAULT NULL,
  `Status` VARCHAR(128) DEFAULT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `IsDestinationNew` TINYINT DEFAULT NULL,
  `CopyProtectedResources` TINYINT DEFAULT NULL,
  `CopyCourseJobId` BIGINT NOT NULL,
  UNIQUE KEY (`CopyCourseJobId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
