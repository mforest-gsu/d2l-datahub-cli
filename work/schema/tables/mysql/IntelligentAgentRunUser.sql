DROP TABLE IF EXISTS `IntelligentAgentRunUser`;

CREATE TABLE `IntelligentAgentRunUser` (
  `AgentId` BIGINT NOT NULL,
  `AgentRunId` BIGINT NOT NULL,
  `UserId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `ActionTypeName` VARCHAR(50) DEFAULT NULL,
  `ActionHasError` TINYINT NOT NULL,
  `ActionHasInfo` TINYINT NOT NULL,
  `ActionHasWarning` TINYINT NOT NULL,
  `ShouldRetry` TINYINT NOT NULL,
  UNIQUE KEY (`AgentId`, `AgentRunId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
