DROP TABLE IF EXISTS `QuizSurveySection`;

CREATE TABLE `QuizSurveySection` (
  `CollectionId` BIGINT DEFAULT NULL,
  `SectionId` BIGINT NOT NULL,
  `Name` VARCHAR(256) DEFAULT NULL,
  `NameIsDisplayed` TINYINT DEFAULT NULL,
  `IsQuestionPool` TINYINT DEFAULT NULL,
  `SectionText` VARCHAR(1000) DEFAULT NULL,
  `SectionTextIsHTML` TINYINT DEFAULT NULL,
  `IsSectionTextHidden` TINYINT DEFAULT NULL,
  `QuestionPoints` DECIMAL(19, 9) DEFAULT NULL,
  `NumQuestions` INT DEFAULT NULL,
  `NumChoices` INT DEFAULT NULL,
  `Shuffle` TINYINT DEFAULT NULL,
  `CreationDate` DATETIME DEFAULT NULL,
  `CreatedBy` BIGINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` BIGINT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`SectionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
