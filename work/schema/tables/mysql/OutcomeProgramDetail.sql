DROP TABLE IF EXISTS `OutcomeProgramDetail`;

CREATE TABLE `OutcomeProgramDetail` (
  `ProgramId` BIGINT NOT NULL,
  `ProgramName` VARCHAR(1000) DEFAULT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  UNIQUE KEY (`ProgramId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

