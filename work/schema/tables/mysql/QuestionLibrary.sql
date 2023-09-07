DROP TABLE IF EXISTS `QuestionLibrary`;

CREATE TABLE `QuestionLibrary` (
  `QuestionId` BIGINT NOT NULL,
  `QuestionVersionId` BIGINT NOT NULL,
  `IsAutoGraded` TINYINT NOT NULL,
  `TemplateTypeId` INT DEFAULT NULL,
  `QuestionType` VARCHAR(28) DEFAULT NULL,
  `Name` VARCHAR(256) DEFAULT NULL,
  `Question` VARCHAR(1000) DEFAULT NULL,
  `Comment` VARCHAR(1000) DEFAULT NULL,
  `AnswerKey` VARCHAR(1000) DEFAULT NULL,
  `CreationDate` DATETIME NOT NULL,
  `Version` BIGINT NOT NULL,
  `AllowsAttachments` TINYINT DEFAULT NULL,
  UNIQUE KEY (`QuestionId`, `QuestionVersionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
