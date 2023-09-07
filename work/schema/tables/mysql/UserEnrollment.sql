DROP TABLE IF EXISTS `UserEnrollment`;

CREATE TABLE `UserEnrollment` (
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `RoleName` VARCHAR(60) NOT NULL,
  `EnrollmentDate` DATETIME NOT NULL,
  `EnrollmentType` VARCHAR(50) DEFAULT NULL,
  `RoleId` INT NOT NULL,
  UNIQUE KEY (`OrgUnitId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
