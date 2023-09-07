DROP TABLE IF EXISTS `ContentUserProgress`;

CREATE TABLE `ContentUserProgress` (
  `ContentObjectId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `CompletedDate` DATETIME NOT NULL,
  `LastVisited` DATETIME DEFAULT NULL,
  `IsRead` TINYINT NOT NULL,
  `NumRealVisits` INT NOT NULL,
  `NumFakeVisits` INT NOT NULL,
  `TotalTime` BIGINT NOT NULL,
  `IsVisited` TINYINT NOT NULL,
  `IsCurrentBookmark` TINYINT NOT NULL,
  `IsSelfAssessComplete` TINYINT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`ContentObjectId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
