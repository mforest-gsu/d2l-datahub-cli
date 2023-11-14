DROP TABLE IF EXISTS `CompetencyActivityLog`;

CREATE TABLE `CompetencyActivityLog` (
  `ActivityId` BIGINT NOT NULL,
  `ActivityLogId` BIGINT NOT NULL,
  `LogTypeId` INT DEFAULT NULL,
  `LogTypeName` VARCHAR(19) DEFAULT NULL,
  `LogDateTime` DATETIME DEFAULT NULL,
  `ModifiedBy` BIGINT DEFAULT NULL,
  UNIQUE KEY (`ActivityId`, `ActivityLogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
