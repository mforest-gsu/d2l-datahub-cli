DROP TABLE IF EXISTS `QuizAttempt_LOAD`;

CREATE TABLE `QuizAttempt_LOAD` (
  `AttemptId` BIGINT NOT NULL,
  `QuizId` BIGINT DEFAULT NULL,
  `UserId` INT DEFAULT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `AttemptNumber` INT DEFAULT NULL,
  `TimeStarted` DATETIME DEFAULT NULL,
  `TimeCompleted` DATETIME DEFAULT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `IsGraded` TINYINT DEFAULT NULL,
  `OldAttemptNumber` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `PossibleScore` DECIMAL(19, 9) DEFAULT NULL,
  `IsRetakeIncorrectOnly` TINYINT DEFAULT NULL,
  `DueDate` DATETIME DEFAULT NULL,
  `TimeLimit` INT DEFAULT NULL,
  `TimeLimitEnforced` TINYINT DEFAULT NULL,
  `GracePeriod` INT DEFAULT NULL,
  `GracePeriodExceededBehaviour` VARCHAR(128) DEFAULT NULL,
  `ExtendedDeadline` INT DEFAULT NULL,
  UNIQUE KEY (`AttemptId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
