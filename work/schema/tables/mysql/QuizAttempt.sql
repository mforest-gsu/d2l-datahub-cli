DROP TABLE IF EXISTS `QuizAttempt`;

CREATE TABLE `QuizAttempt` (
  `AttemptId` BIGINT NOT NULL,
  `QuizId` BIGINT NOT NULL,
  `UserId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `AttemptNumber` INT NOT NULL,
  `TimeStarted` DATETIME NOT NULL,
  `TimeCompleted` DATETIME DEFAULT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `IsGraded` TINYINT NOT NULL,
  `OldAttemptNumber` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `PossibleScore` DECIMAL(19, 9) DEFAULT NULL,
  `IsRetakeIncorrectOnly` TINYINT NOT NULL,
  `DueDate` DATETIME DEFAULT NULL,
  `TimeLimit` INT DEFAULT NULL,
  `TimeLimitEnforced` TINYINT DEFAULT NULL,
  `GracePeriod` INT DEFAULT NULL,
  `GracePeriodExceededBehaviour` VARCHAR(128) DEFAULT NULL,
  `ExtendedDeadline` INT DEFAULT NULL,
  UNIQUE KEY (`AttemptId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
