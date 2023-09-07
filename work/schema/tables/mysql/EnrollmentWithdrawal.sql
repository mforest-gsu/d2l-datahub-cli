DROP TABLE IF EXISTS `EnrollmentWithdrawal`;

CREATE TABLE `EnrollmentWithdrawal` (
  `LogId` BIGINT NOT NULL,
  `UserId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `RoleId` INT DEFAULT NULL,
  `Action` VARCHAR(50) NOT NULL,
  `EnrollmentType` VARCHAR(50) DEFAULT NULL,
  `ModifiedByUserId` INT DEFAULT NULL,
  `EnrollmentDate` DATETIME NOT NULL,
  UNIQUE KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
