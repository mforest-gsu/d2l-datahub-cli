DROP TABLE IF EXISTS `ChatSessionLog`;

CREATE TABLE `ChatSessionLog` (
  `OrgUnitId` INT DEFAULT NULL,
  `UserId` INT DEFAULT NULL,
  `ChatSessionId` BIGINT DEFAULT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `TimeSent` DATETIME DEFAULT NULL,
  `MessageId` BIGINT NOT NULL,
  UNIQUE KEY (`MessageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

