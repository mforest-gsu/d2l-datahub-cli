DROP TABLE IF EXISTS `QuizQuestionAnswerOption`;

CREATE TABLE `QuizQuestionAnswerOption` (
  `AnswerId` BIGINT NOT NULL,
  `AnswerText` VARCHAR(1000) DEFAULT NULL,
  `Weight` DECIMAL(19, 9) DEFAULT NULL,
  `QuestionId` BIGINT NOT NULL,
  `QuestionVersionId` BIGINT NOT NULL,
  `QuizObjectId` BIGINT NOT NULL,
  `AnswerOptionId` BIGINT NOT NULL,
  UNIQUE KEY (`AnswerId`, `QuestionId`, `QuestionVersionId`, `QuizObjectId`, `AnswerOptionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
