DROP TABLE IF EXISTS `IntelligentAgentRunUser`;

CREATE TABLE `IntelligentAgentRunUser` (
  `AgentId` BIGINT NOT NULL,
  `AgentRunId` BIGINT NOT NULL,
  `UserId` INT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `ActionTypeName` VARCHAR(50) DEFAULT NULL,
  `ActionHasError` TINYINT DEFAULT NULL,
  `ActionHasInfo` TINYINT DEFAULT NULL,
  `ActionHasWarning` TINYINT DEFAULT NULL,
  `ShouldRetry` TINYINT DEFAULT NULL,
  UNIQUE KEY (`AgentId`, `AgentRunId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
