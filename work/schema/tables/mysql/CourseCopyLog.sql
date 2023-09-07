DROP TABLE IF EXISTS `CourseCopyLog`;

CREATE TABLE `CourseCopyLog` (
  `SourceOrgUnitId` INT NOT NULL,
  `DestinationOrgUnitId` INT NOT NULL,
  `UserId` BIGINT DEFAULT NULL,
  `Status` VARCHAR(128) NOT NULL,
  `StartDate` DATETIME NOT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `IsDestinationNew` TINYINT NOT NULL,
  `CopyProtectedResources` TINYINT NOT NULL,
  `CopyCourseJobId` BIGINT NOT NULL,
  UNIQUE KEY (`CopyCourseJobId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
