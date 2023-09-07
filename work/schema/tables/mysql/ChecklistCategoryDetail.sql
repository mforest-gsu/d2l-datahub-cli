DROP TABLE IF EXISTS `ChecklistCategoryDetail`;

CREATE TABLE `ChecklistCategoryDetail` (
  `CategoryId` BIGINT NOT NULL,
  `ChecklistId` BIGINT NOT NULL,
  `Name` VARCHAR(512) NOT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `DescriptionIsHtml` TINYINT NOT NULL,
  `SortOrder` INT NOT NULL,
  `LastModifiedUtc` DATETIME DEFAULT NULL,
  UNIQUE KEY (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
