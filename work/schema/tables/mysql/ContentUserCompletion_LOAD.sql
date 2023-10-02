DROP TABLE IF EXISTS `ContentUserCompletion_LOAD`;

CREATE TABLE `ContentUserCompletion_LOAD` (
  `ContentObjectId` INT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `UserId` INT NOT NULL,
  `DateCompleted` DATETIME DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`ContentObjectId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
