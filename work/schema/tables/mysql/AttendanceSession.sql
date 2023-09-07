DROP TABLE IF EXISTS `AttendanceSession`;

CREATE TABLE `AttendanceSession` (
  `AttendanceSessionId` BIGINT NOT NULL,
  `AttendanceRegisterId` BIGINT NOT NULL,
  `Name` VARCHAR(128) NOT NULL,
  `Description` VARCHAR(256) DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`AttendanceSessionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
