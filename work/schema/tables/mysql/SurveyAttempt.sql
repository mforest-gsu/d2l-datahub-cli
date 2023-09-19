DROP TABLE IF EXISTS `SurveyAttempt`;

CREATE TABLE `SurveyAttempt` (
  `AttemptId` BIGINT NOT NULL,
  `SurveyId` BIGINT DEFAULT NULL,
  `UserId` INT DEFAULT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `AttemptNumber` INT DEFAULT NULL,
  `TimeStarted` DATETIME DEFAULT NULL,
  `TimeCompleted` DATETIME DEFAULT NULL,
  `AttemptedFromOrgUnitId` INT DEFAULT NULL,
  `OldAttemptNumber` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`AttemptId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
