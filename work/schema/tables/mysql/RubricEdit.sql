DROP TABLE IF EXISTS `RubricEdit`;

CREATE TABLE `RubricEdit` (
  `AuditLogId` VARCHAR(16) NOT NULL,
  `RubricId` BIGINT NOT NULL,
  `CriterionId` BIGINT DEFAULT NULL,
  `LevelId` BIGINT DEFAULT NULL,
  `ModifiedBy` INT NOT NULL,
  `ModifiedObjectType` INT NOT NULL,
  `CriteriaGroupId` BIGINT DEFAULT NULL,
  `ModifiedDate` DATETIME NOT NULL,
  `PreviousValue` VARCHAR(4000) NOT NULL,
  `ModifiedValue` VARCHAR(4000) NOT NULL,
  `IsLocked` TINYINT NOT NULL,
  `Version` INT NOT NULL,
  UNIQUE KEY (`AuditLogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
