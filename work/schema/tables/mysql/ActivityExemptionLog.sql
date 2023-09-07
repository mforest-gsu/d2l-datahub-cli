DROP TABLE IF EXISTS `ActivityExemptionLog`;

CREATE TABLE `ActivityExemptionLog` (
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `ObjectId` INT DEFAULT NULL,
  `ActivityId` VARCHAR(225) NOT NULL,
  `LogTypeName` VARCHAR(50) DEFAULT NULL,
  `LastModifiedUtc` DATETIME NOT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `ActivityExemptionsLogId` BIGINT NOT NULL,
  `ToolId` INT NOT NULL,
  UNIQUE KEY (`ActivityExemptionsLogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
