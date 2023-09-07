DROP TABLE IF EXISTS `QuestionRelationship`;

CREATE TABLE `QuestionRelationship` (
  `CollectionId` BIGINT NOT NULL,
  `QuestionId` BIGINT DEFAULT NULL,
  `QuestionVersionId` BIGINT DEFAULT NULL,
  `Order` BIGINT NOT NULL,
  `SectionId` BIGINT DEFAULT NULL,
  `IsQuestionPool` TINYINT NOT NULL,
  `CreationDate` DATETIME NOT NULL,
  `CreatedBy` BIGINT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  `LastModifiedBy` BIGINT DEFAULT NULL,
  `Points` DECIMAL(19, 9) DEFAULT NULL,
  `Difficulty` INT DEFAULT NULL,
  `IsBonus` TINYINT DEFAULT NULL,
  `IsMandatory` TINYINT DEFAULT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `Version` BIGINT DEFAULT NULL,
  `ObjectId` BIGINT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
