DROP TABLE IF EXISTS `IntelligentAgentRunLog`;

CREATE TABLE `IntelligentAgentRunLog` (
  `AgentId` BIGINT DEFAULT NULL,
  `AgentRunId` BIGINT NOT NULL,
  `IsPracticeRun` TINYINT DEFAULT NULL,
  `IsRunNow` TINYINT DEFAULT NULL,
  `NumUsers` INT DEFAULT NULL,
  `NumUsersWithErrors` INT DEFAULT NULL,
  `NumUsersWithInfos` INT DEFAULT NULL,
  `NumUsersWithWarnings` INT DEFAULT NULL,
  `RunUserId` INT DEFAULT NULL,
  `RunDate` DATETIME DEFAULT NULL,
  UNIQUE KEY (`AgentRunId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

