DROP TABLE IF EXISTS `LTILaunch_LOAD`;

CREATE TABLE `LTILaunch_LOAD` (
  `LTILaunchId` VARCHAR(36) NOT NULL,
  `UserId` INT DEFAULT NULL,
  `IMSRoleNames` VARCHAR(9999) DEFAULT NULL,
  `ImpersonatingUserId` BIGINT DEFAULT NULL,
  `ImpersonatingUserIMSRoleNames` VARCHAR(9999) DEFAULT NULL,
  `LaunchDate` DATETIME DEFAULT NULL,
  `OrgUnitId` BIGINT DEFAULT NULL,
  `LTILinkId` BIGINT DEFAULT NULL,
  `DeploymentId` VARCHAR(36) DEFAULT NULL,
  `ClientId` VARCHAR(36) DEFAULT NULL,
  `ToolProviderId` VARCHAR(300) DEFAULT NULL,
  `ContentTopicId` BIGINT DEFAULT NULL,
  `ParentModuleId` BIGINT DEFAULT NULL,
  `Placement` VARCHAR(10) DEFAULT NULL,
  `MessageVersion` VARCHAR(10) DEFAULT NULL,
  `RequestType` VARCHAR(30) DEFAULT NULL,
  UNIQUE KEY (`LTILaunchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;