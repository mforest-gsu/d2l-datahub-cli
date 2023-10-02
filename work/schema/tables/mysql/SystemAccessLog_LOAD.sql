DROP TABLE IF EXISTS `SystemAccessLog_LOAD`;

CREATE TABLE `SystemAccessLog_LOAD` (
  `SessionId` VARCHAR(36) NOT NULL,
  `UserId` INT NOT NULL,
  `Timestamp` DATETIME NOT NULL,
  `State` VARCHAR(20) NOT NULL,
  `Source` VARCHAR(20) DEFAULT NULL,
  `AppVersion` VARCHAR(20) DEFAULT NULL,
  `Device` VARCHAR(50) DEFAULT NULL,
  `IsOfflineMode` TINYINT DEFAULT NULL,
  `IPAddress` VARCHAR(45) DEFAULT NULL,
  UNIQUE KEY (`SessionId`, `UserId`, `Timestamp`, `State`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
