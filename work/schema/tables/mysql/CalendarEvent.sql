DROP TABLE IF EXISTS `CalendarEvent`;

CREATE TABLE `CalendarEvent` (
  `ScheduleId` BIGINT NOT NULL,
  `OrgUnitId` BIGINT DEFAULT NULL,
  `UserId` BIGINT DEFAULT NULL,
  `Title` VARCHAR(256) NOT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `TimeZoneIdentifier` VARCHAR(256) NOT NULL,
  `IsAllDayEvent` TINYINT NOT NULL,
  `RecurrenceType` VARCHAR(7) DEFAULT NULL,
  `RecurrenceInterval` INT NOT NULL,
  `CreatedByUserId` INT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `EventObjectTypeName` VARCHAR(200) DEFAULT NULL,
  `ObjectLookupId1` BIGINT DEFAULT NULL,
  `ObjectLookupId2` BIGINT DEFAULT NULL,
  UNIQUE KEY (`ScheduleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
