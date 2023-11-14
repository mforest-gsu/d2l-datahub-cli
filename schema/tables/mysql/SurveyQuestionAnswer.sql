DROP TABLE IF EXISTS `SurveyQuestionAnswer`;

CREATE TABLE `SurveyQuestionAnswer` (
  `AnswerId` BIGINT NOT NULL,
  `QuestionId` BIGINT NOT NULL,
  `QuestionVersionId` BIGINT NOT NULL,
  `SortOrder` INT DEFAULT NULL,
  `IsCorrect` TINYINT DEFAULT NULL,
  `Weight` DECIMAL(19, 9) DEFAULT NULL,
  `Answer` VARCHAR(1000) DEFAULT NULL,
  `Comment` VARCHAR(1000) DEFAULT NULL,
  `Description` VARCHAR(256) DEFAULT NULL,
  `SurveyObjectId` BIGINT NOT NULL,
  UNIQUE KEY (`AnswerId`, `QuestionId`, `QuestionVersionId`, `SurveyObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
