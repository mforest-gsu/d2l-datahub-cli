DROP TABLE IF EXISTS `SurveyUserAnswer`;

CREATE TABLE `SurveyUserAnswer` (
  `AttemptId` BIGINT NOT NULL,
  `QuestionId` BIGINT NOT NULL,
  `QuestionVersionId` BIGINT DEFAULT NULL,
  `TimeCompleted` DATETIME DEFAULT NULL,
  `QuestionNumber` INT DEFAULT NULL,
  `Comment` VARCHAR(1000) DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `Page` INT DEFAULT NULL,
  `Assigned` TINYINT DEFAULT NULL,
  UNIQUE KEY (`AttemptId`, `QuestionId`, `QuestionVersionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

