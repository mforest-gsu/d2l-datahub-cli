DROP TABLE IF EXISTS `SCORMInteractionAttempt`;

CREATE TABLE `SCORMInteractionAttempt` (
  `VisitId` VARCHAR(16) NOT NULL,
  `InteractionId` VARCHAR(16) NOT NULL,
  `AttemptNumber` INT NOT NULL,
  `ActivityId` VARCHAR(16) NOT NULL,
  `Timestamp` DATETIME DEFAULT NULL,
  `Response` VARCHAR(1000) DEFAULT NULL,
  `Result` VARCHAR(100) DEFAULT NULL,
  `NumericResult` FLOAT DEFAULT NULL,
  `TimeSpent` FLOAT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`VisitId`, `InteractionId`, `AttemptNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
