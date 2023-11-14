DROP TABLE IF EXISTS `QuizQuestionAnswer_LOAD`;

CREATE TABLE `QuizQuestionAnswer_LOAD` (
  `AnswerId` BIGINT NOT NULL,
  `QuestionId` BIGINT NOT NULL,
  `QuestionVersionId` BIGINT NOT NULL,
  `SortOrder` INT DEFAULT NULL,
  `IsCorrect` TINYINT DEFAULT NULL,
  `Weight` DECIMAL(19, 9) DEFAULT NULL,
  `Answer` VARCHAR(1000) DEFAULT NULL,
  `Comment` VARCHAR(1000) DEFAULT NULL,
  `Description` VARCHAR(256) DEFAULT NULL,
  `ObjectId` BIGINT NOT NULL,
  UNIQUE KEY (`AnswerId`, `QuestionId`, `QuestionVersionId`, `ObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
