DROP TABLE IF EXISTS `OutcomeRubricAlignment`;

CREATE TABLE `OutcomeRubricAlignment` (
  `RubricId` BIGINT NOT NULL,
  `CriterionId` BIGINT NOT NULL,
  `OutcomeId` VARCHAR(16) NOT NULL,
  `RegistryId` VARCHAR(16) NOT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  UNIQUE KEY (`RubricId`, `CriterionId`, `OutcomeId`, `RegistryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
