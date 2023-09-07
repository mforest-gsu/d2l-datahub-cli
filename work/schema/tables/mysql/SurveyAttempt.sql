DROP TABLE IF EXISTS `SurveyAttempt`;

CREATE TABLE `SurveyAttempt` (
  `AttemptId` BIGINT NOT NULL,
  `SurveyId` BIGINT NOT NULL,
  `UserId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `AttemptNumber` INT NOT NULL,
  `TimeStarted` DATETIME NOT NULL,
  `TimeCompleted` DATETIME DEFAULT NULL,
  `AttemptedFromOrgUnitId` INT DEFAULT NULL,
  `OldAttemptNumber` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`AttemptId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
