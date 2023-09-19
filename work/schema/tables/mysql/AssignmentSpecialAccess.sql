DROP TABLE IF EXISTS `AssignmentSpecialAccess`;

CREATE TABLE `AssignmentSpecialAccess` (
  `DropboxId` BIGINT NOT NULL,
  `UserId` INT NOT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `DueDate` DATETIME DEFAULT NULL,
  `ModifiedBy` INT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `StartDateAvailabilityType` VARCHAR(2) DEFAULT NULL,
  `EndDateAvailabilityType` VARCHAR(2) DEFAULT NULL,
  UNIQUE KEY (`DropboxId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
