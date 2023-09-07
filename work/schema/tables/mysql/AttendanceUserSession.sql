DROP TABLE IF EXISTS `AttendanceUserSession`;

CREATE TABLE `AttendanceUserSession` (
  `UserId` INT NOT NULL,
  `AttendanceSessionId` BIGINT NOT NULL,
  `SchemeSymbolId` BIGINT NOT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  UNIQUE KEY (`UserId`, `AttendanceSessionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
