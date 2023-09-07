DROP TABLE IF EXISTS `QuizUserAnswer`;

CREATE TABLE `QuizUserAnswer` (
  `AttemptId` BIGINT NOT NULL,
  `QuestionId` BIGINT NOT NULL,
  `QuestionVersionId` BIGINT DEFAULT NULL,
  `TimeCompleted` DATETIME DEFAULT NULL,
  `QuestionNumber` INT DEFAULT NULL,
  `Comment` VARCHAR(1000) DEFAULT NULL,
  `SortOrder` INT NOT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `Page` INT NOT NULL,
  `SectionId` BIGINT DEFAULT NULL,
  `ObjectId` BIGINT NOT NULL,
  UNIQUE KEY (`AttemptId`, `ObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
