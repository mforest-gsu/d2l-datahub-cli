DROP TABLE IF EXISTS `AttendanceUserSession_LOAD`;

CREATE TABLE `AttendanceUserSession_LOAD` (
  `UserId` INT NOT NULL,
  `AttendanceSessionId` BIGINT NOT NULL,
  `SchemeSymbolId` BIGINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  UNIQUE KEY (`UserId`, `AttendanceSessionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
