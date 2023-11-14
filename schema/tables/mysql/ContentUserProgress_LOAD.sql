DROP TABLE IF EXISTS `ContentUserProgress_LOAD`;

CREATE TABLE `ContentUserProgress_LOAD` (
  `ContentObjectId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `CompletedDate` DATETIME DEFAULT NULL,
  `LastVisited` DATETIME DEFAULT NULL,
  `IsRead` TINYINT DEFAULT NULL,
  `NumRealVisits` INT DEFAULT NULL,
  `NumFakeVisits` INT DEFAULT NULL,
  `TotalTime` BIGINT DEFAULT NULL,
  `IsVisited` TINYINT DEFAULT NULL,
  `IsCurrentBookmark` TINYINT DEFAULT NULL,
  `IsSelfAssessComplete` TINYINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`ContentObjectId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
