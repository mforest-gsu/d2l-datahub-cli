DROP TABLE IF EXISTS `OutcomeDetail`;

CREATE TABLE `OutcomeDetail` (
  `OutcomeId` VARCHAR(36) NOT NULL,
  `OutcomeDefinitionSource` VARCHAR(1000) DEFAULT NULL,
  `OutcomeDefinitionId` VARCHAR(128) DEFAULT NULL,
  `ParentOutcomeId` VARCHAR(36) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `Notation` VARCHAR(1000) DEFAULT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  UNIQUE KEY (`OutcomeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
