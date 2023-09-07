DROP TABLE IF EXISTS `ChecklistItemDetail`;

CREATE TABLE `ChecklistItemDetail` (
  `ItemId` BIGINT NOT NULL,
  `CategoryId` BIGINT DEFAULT NULL,
  `Name` VARCHAR(512) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `DescriptionIsHtml` TINYINT NOT NULL,
  `DueDate` DATETIME DEFAULT NULL,
  `ScheduleId` INT DEFAULT NULL,
  `SortOrder` INT NOT NULL,
  `IsAutoChecked` TINYINT NOT NULL,
  `LastModifiedUtc` DATETIME DEFAULT NULL,
  UNIQUE KEY (`ItemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
