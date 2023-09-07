DROP TABLE IF EXISTS `ChatSessionLog`;

CREATE TABLE `ChatSessionLog` (
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `ChatSessionId` BIGINT NOT NULL,
  `StartDate` DATETIME NOT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `TimeSent` DATETIME NOT NULL,
  `MessageId` BIGINT NOT NULL,
  UNIQUE KEY (`MessageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
