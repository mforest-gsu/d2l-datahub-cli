DROP TABLE IF EXISTS `VirtualClassroomUsage`;

CREATE TABLE `VirtualClassroomUsage` (
  `OrgUnitId` INT NOT NULL,
  `CourseName` VARCHAR(255) NOT NULL,
  `MeetingId` VARCHAR(36) NOT NULL,
  `MeetingName` VARCHAR(255) NOT NULL,
  `CreationUserId` INT NOT NULL,
  `CreationDate` DATETIME NOT NULL,
  `ScheduledDate` DATETIME NOT NULL,
  `ScheduledDuration` INT NOT NULL,
  `IsPublished` TINYINT NOT NULL,
  `ExternalLinksEnabled` TINYINT NOT NULL,
  `WholeClassInvited` TINYINT NOT NULL,
  `IsCancelled` TINYINT NOT NULL,
  `StartDateTime` DATETIME NOT NULL,
  `EndDateTime` DATETIME NOT NULL,
  `IsRecorded` TINYINT NOT NULL,
  UNIQUE KEY (`MeetingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
