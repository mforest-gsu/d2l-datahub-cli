DROP TABLE IF EXISTS `SurveyUserAnswerResponse`;

CREATE TABLE `SurveyUserAnswerResponse` (
  `AttemptId` BIGINT NOT NULL,
  `AttemptNumber` INT DEFAULT NULL,
  `QuestionId` BIGINT NOT NULL,
  `QuestionVersionId` BIGINT NOT NULL,
  `AnswerId` BIGINT NOT NULL,
  `SortOrder` BIGINT DEFAULT NULL,
  `IsCorrect` TINYINT DEFAULT NULL,
  `UserSelection` BIGINT DEFAULT NULL,
  `UserAnswer` VARCHAR(1000) DEFAULT NULL,
  `FileSetId` BIGINT DEFAULT NULL,
  UNIQUE KEY (`AttemptId`, `QuestionId`, `QuestionVersionId`, `AnswerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
