DROP TABLE IF EXISTS `SystemAccessLog`;

CREATE TABLE `SystemAccessLog` (
  `SessionId` VARCHAR(36) NOT NULL,
  `UserId` INT NOT NULL,
  `Timestamp` DATETIME NOT NULL,
  `State` VARCHAR(20) NOT NULL,
  `Source` VARCHAR(20) NOT NULL,
  `AppVersion` VARCHAR(20) NOT NULL,
  `Device` VARCHAR(50) NOT NULL,
  `IsOfflineMode` TINYINT NOT NULL,
  `IPAddress` VARCHAR(45) DEFAULT NULL,
  UNIQUE KEY (`SessionId`, `UserId`, `Timestamp`, `State`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
