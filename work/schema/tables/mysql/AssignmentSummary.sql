DROP TABLE IF EXISTS `AssignmentSummary`;

CREATE TABLE `AssignmentSummary` (
  `DropboxId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `Name` VARCHAR(128) NOT NULL,
  `Category` VARCHAR(128) DEFAULT NULL,
  `Type` VARCHAR(10) NOT NULL,
  `GradeItemId` BIGINT DEFAULT NULL,
  `PossibleScore` DECIMAL(19, 9) DEFAULT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `DueDate` DATETIME DEFAULT NULL,
  `IsRestricted` TINYINT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `TurnItInEnabled` TINYINT NOT NULL,
  `IsHidden` TINYINT NOT NULL,
  `SortOrder` INT NOT NULL,
  `SubmissionType` VARCHAR(18) NOT NULL,
  `CompletionType` VARCHAR(27) NOT NULL,
  `ResultId` INT DEFAULT NULL,
  `CategoryId` BIGINT DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  `StartDateAvailabilityType` VARCHAR(2) DEFAULT NULL,
  `EndDateAvailabilityType` VARCHAR(2) DEFAULT NULL,
  UNIQUE KEY (`DropboxId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
