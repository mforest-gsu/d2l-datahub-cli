DROP TABLE IF EXISTS `AttendanceScheme`;

CREATE TABLE `AttendanceScheme` (
  `SchemeId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `SchemeName` VARCHAR(128) DEFAULT NULL,
  `SchemeSymbolId` BIGINT NOT NULL,
  `SymbolName` VARCHAR(128) DEFAULT NULL,
  `SymbolValue` VARCHAR(50) DEFAULT NULL,
  `Percentage` DECIMAL(19, 9) DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`SchemeId`, `SchemeSymbolId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

