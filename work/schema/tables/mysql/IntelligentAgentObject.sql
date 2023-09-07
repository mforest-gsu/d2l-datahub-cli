DROP TABLE IF EXISTS `IntelligentAgentObject`;

CREATE TABLE `IntelligentAgentObject` (
  `AgentId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `AgentName` VARCHAR(128) NOT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `Enabled` TINYINT NOT NULL,
  `SpecificRoles` VARCHAR(1000) DEFAULT NULL,
  `LoginConditionEnabled` TINYINT NOT NULL,
  `LoginConditionThreshold` INT DEFAULT NULL,
  `LoginConditionType` VARCHAR(14) DEFAULT NULL,
  `AccessConditionEnabled` TINYINT NOT NULL,
  `AccessConditionThreshold` INT DEFAULT NULL,
  `AccessConditionType` VARCHAR(20) DEFAULT NULL,
  `ResultId` BIGINT DEFAULT NULL,
  `RepeatType` VARCHAR(10) NOT NULL,
  `EmailWhenSatisfied` TINYINT NOT NULL,
  `EnableSchedule` TINYINT NOT NULL,
  `ScheduleType` VARCHAR(8) DEFAULT NULL,
  `ScheduleRepeatsEvery` INT DEFAULT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT NOT NULL,
  UNIQUE KEY (`AgentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
