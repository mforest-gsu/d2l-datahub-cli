DROP TABLE IF EXISTS `ContentUserCompletion`;

CREATE TABLE `ContentUserCompletion` (
  `ContentObjectId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `DateCompleted` DATETIME DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`ContentObjectId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
