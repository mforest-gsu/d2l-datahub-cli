DROP TABLE IF EXISTS `AttendanceScheme`;

CREATE TABLE `AttendanceScheme` (
  `SchemeId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `SchemeName` VARCHAR(128) NOT NULL,
  `SchemeSymbolId` BIGINT NOT NULL,
  `SymbolName` VARCHAR(128) NOT NULL,
  `SymbolValue` VARCHAR(50) NOT NULL,
  `Percentage` DECIMAL(19, 9) DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`SchemeId`, `SchemeSymbolId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
