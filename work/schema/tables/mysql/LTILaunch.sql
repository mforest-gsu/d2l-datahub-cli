DROP TABLE IF EXISTS `LTILaunch`;

CREATE TABLE `LTILaunch` (
  `LTILaunchId` VARCHAR(16) NOT NULL,
  `UserId` INT DEFAULT NULL,
  `IMSRoleNames` TEXT(10000) DEFAULT NULL,
  `ImpersonatingUserId` BIGINT DEFAULT NULL,
  `ImpersonatingUserIMSRoleName` TEXT(10000) DEFAULT NULL,
  `LaunchDate` DATETIME DEFAULT NULL,
  `OrgUnitId` BIGINT DEFAULT NULL,
  `LTILinkId` BIGINT DEFAULT NULL,
  `DeploymentId` VARCHAR(16) DEFAULT NULL,
  `ClientId` VARCHAR(16) DEFAULT NULL,
  `ToolProviderId` VARCHAR(300) DEFAULT NULL,
  `ContentTopicId` BIGINT DEFAULT NULL,
  `ParentModuleId` BIGINT DEFAULT NULL,
  `Placement` VARCHAR(10) DEFAULT NULL,
  `MessageVersion` VARCHAR(10) DEFAULT NULL,
  `RequestType` VARCHAR(30) DEFAULT NULL,
  UNIQUE KEY (`LTILaunchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
