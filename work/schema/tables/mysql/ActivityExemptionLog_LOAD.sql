DROP TABLE IF EXISTS `ActivityExemptionLog_LOAD`;

CREATE TABLE `ActivityExemptionLog_LOAD` (
  `OrgUnitId` INT DEFAULT NULL,
  `UserId` INT DEFAULT NULL,
  `ObjectId` INT DEFAULT NULL,
  `ActivityId` VARCHAR(225) DEFAULT NULL,
  `LogTypeName` VARCHAR(50) DEFAULT NULL,
  `LastModifiedUtc` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `ActivityExemptionsLogId` BIGINT NOT NULL,
  `ToolId` INT DEFAULT NULL,
  UNIQUE KEY (`ActivityExemptionsLogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
