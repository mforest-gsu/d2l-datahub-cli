DROP TABLE IF EXISTS `OutcomeProgramDetail`;

CREATE TABLE `OutcomeProgramDetail` (
  `ProgramId` BIGINT NOT NULL,
  `ProgramName` VARCHAR(1000) NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  UNIQUE KEY (`ProgramId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
