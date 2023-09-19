DROP TABLE IF EXISTS `CoursePublisherLaunch`;

CREATE TABLE `CoursePublisherLaunch` (
  `LaunchId` VARCHAR(16) NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `RecipientId` VARCHAR(16) DEFAULT NULL,
  `UserId` INT DEFAULT NULL,
  `RoleId` INT DEFAULT NULL,
  `LaunchMethod` VARCHAR(256) DEFAULT NULL,
  `ExternalUserId` VARCHAR(256) DEFAULT NULL,
  `ExternalLMSType` VARCHAR(256) DEFAULT NULL,
  `IsNewUser` TINYINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`LaunchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
