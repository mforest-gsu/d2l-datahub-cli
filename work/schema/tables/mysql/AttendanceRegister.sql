DROP TABLE IF EXISTS `AttendanceRegister`;

CREATE TABLE `AttendanceRegister` (
  `AttendanceRegisterId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `Name` VARCHAR(128) NOT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `SchemeId` BIGINT NOT NULL,
  `IsVisible` TINYINT NOT NULL,
  `IncludeAllUsers` TINYINT NOT NULL,
  `CauseForConcern` DECIMAL(19, 9) DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`AttendanceRegisterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
