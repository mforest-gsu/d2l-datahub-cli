DROP TABLE IF EXISTS `QuizSurveySection`;

CREATE TABLE `QuizSurveySection` (
  `CollectionId` BIGINT NOT NULL,
  `SectionId` BIGINT NOT NULL,
  `Name` VARCHAR(256) DEFAULT NULL,
  `NameIsDisplayed` TINYINT NOT NULL,
  `IsQuestionPool` TINYINT NOT NULL,
  `SectionText` VARCHAR(1000) DEFAULT NULL,
  `SectionTextIsHTML` TINYINT NOT NULL,
  `IsSectionTextHidden` TINYINT DEFAULT NULL,
  `QuestionPoints` DECIMAL(19, 9) DEFAULT NULL,
  `NumQuestions` INT NOT NULL,
  `NumChoices` INT NOT NULL,
  `Shuffle` TINYINT NOT NULL,
  `CreationDate` DATETIME NOT NULL,
  `CreatedBy` BIGINT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  `LastModifiedBy` BIGINT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`SectionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
