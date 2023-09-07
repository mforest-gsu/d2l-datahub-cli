DROP TABLE IF EXISTS `IntelligentAgentRunLog`;

CREATE TABLE `IntelligentAgentRunLog` (
  `AgentId` BIGINT NOT NULL,
  `AgentRunId` BIGINT NOT NULL,
  `IsPracticeRun` TINYINT NOT NULL,
  `IsRunNow` TINYINT NOT NULL,
  `NumUsers` INT NOT NULL,
  `NumUsersWithErrors` INT NOT NULL,
  `NumUsersWithInfos` INT NOT NULL,
  `NumUsersWithWarnings` INT NOT NULL,
  `RunUserId` INT NOT NULL,
  `RunDate` DATETIME NOT NULL,
  UNIQUE KEY (`AgentRunId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
