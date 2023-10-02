DROP TABLE IF EXISTS `UserEnrollment_LOAD`;

CREATE TABLE `UserEnrollment_LOAD` (
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `RoleName` VARCHAR(60) DEFAULT NULL,
  `EnrollmentDate` DATETIME DEFAULT NULL,
  `EnrollmentType` VARCHAR(50) DEFAULT NULL,
  `RoleId` INT DEFAULT NULL,
  UNIQUE KEY (`OrgUnitId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
