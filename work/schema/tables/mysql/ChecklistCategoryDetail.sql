DROP TABLE IF EXISTS `ChecklistCategoryDetail`;

CREATE TABLE `ChecklistCategoryDetail` (
  `CategoryId` BIGINT NOT NULL,
  `ChecklistId` BIGINT DEFAULT NULL,
  `Name` VARCHAR(512) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `DescriptionIsHtml` TINYINT DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `LastModifiedUtc` DATETIME DEFAULT NULL,
  `DateDeleted` DATETIME DEFAULT NULL,
  `DeletedBy` INT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
