DROP TABLE IF EXISTS `VirtualClassroomUsage_LOAD`;

CREATE TABLE `VirtualClassroomUsage_LOAD` (
  `OrgUnitId` INT DEFAULT NULL,
  `CourseName` VARCHAR(255) DEFAULT NULL,
  `MeetingId` VARCHAR(36) NOT NULL,
  `MeetingName` VARCHAR(255) DEFAULT NULL,
  `CreationUserId` INT DEFAULT NULL,
  `CreationDate` DATETIME DEFAULT NULL,
  `ScheduledDate` DATETIME DEFAULT NULL,
  `ScheduledDuration` INT DEFAULT NULL,
  `IsPublished` TINYINT DEFAULT NULL,
  `ExternalLinksEnabled` TINYINT DEFAULT NULL,
  `WholeClassInvited` TINYINT DEFAULT NULL,
  `IsCancelled` TINYINT DEFAULT NULL,
  `StartDateTime` DATETIME DEFAULT NULL,
  `EndDateTime` DATETIME DEFAULT NULL,
  `IsRecorded` TINYINT DEFAULT NULL,
  UNIQUE KEY (`MeetingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
