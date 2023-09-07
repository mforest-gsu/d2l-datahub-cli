DROP TABLE IF EXISTS `CoursePublisherLaunch`;

CREATE TABLE `CoursePublisherLaunch` (
  `LaunchId` VARCHAR(16) NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `RecipientId` VARCHAR(16) NOT NULL,
  `UserId` INT NOT NULL,
  `RoleId` INT NOT NULL,
  `LaunchMethod` VARCHAR(256) NOT NULL,
  `ExternalUserId` VARCHAR(256) NOT NULL,
  `ExternalLMSType` VARCHAR(256) NOT NULL,
  `IsNewUser` TINYINT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`LaunchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
