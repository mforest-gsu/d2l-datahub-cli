DROP TABLE IF EXISTS `AttendanceRegister`;

CREATE TABLE `AttendanceRegister` (
  `AttendanceRegisterId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `Name` VARCHAR(128) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `SchemeId` BIGINT DEFAULT NULL,
  `IsVisible` TINYINT DEFAULT NULL,
  `IncludeAllUsers` TINYINT DEFAULT NULL,
  `CauseForConcern` DECIMAL(19, 9) DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`AttendanceRegisterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

