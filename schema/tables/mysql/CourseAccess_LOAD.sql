DROP TABLE IF EXISTS `CourseAccess_LOAD`;

CREATE TABLE `CourseAccess_LOAD` (
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `DayAccessed` DATETIME NOT NULL,
  UNIQUE KEY (`OrgUnitId`, `UserId`, `DayAccessed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
