DROP TABLE IF EXISTS `ChecklistCompletion`;

CREATE TABLE `ChecklistCompletion` (
  `UserId` INT NOT NULL,
  `DateCompleted` DATETIME NOT NULL,
  `ItemId` BIGINT NOT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`UserId`, `ItemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
