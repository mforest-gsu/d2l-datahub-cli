DROP TABLE IF EXISTS `EnrollmentWithdrawal_LOAD`;

CREATE TABLE `EnrollmentWithdrawal_LOAD` (
  `LogId` BIGINT NOT NULL,
  `UserId` INT DEFAULT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `RoleId` INT DEFAULT NULL,
  `Action` VARCHAR(50) DEFAULT NULL,
  `EnrollmentType` VARCHAR(50) DEFAULT NULL,
  `ModifiedByUserId` INT DEFAULT NULL,
  `EnrollmentDate` DATETIME DEFAULT NULL,
  UNIQUE KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
