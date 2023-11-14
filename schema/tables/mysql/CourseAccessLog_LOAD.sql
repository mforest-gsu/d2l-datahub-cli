DROP TABLE IF EXISTS `CourseAccessLog_LOAD`;

CREATE TABLE `CourseAccessLog_LOAD` (
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `Timestamp` DATETIME NOT NULL,
  `Source` VARCHAR(20) NOT NULL,
  UNIQUE KEY (`OrgUnitId`, `UserId`, `Timestamp`, `Source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
