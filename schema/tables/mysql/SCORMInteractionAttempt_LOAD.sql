DROP TABLE IF EXISTS `SCORMInteractionAttempt_LOAD`;

CREATE TABLE `SCORMInteractionAttempt_LOAD` (
  `VisitId` VARCHAR(36) NOT NULL,
  `InteractionId` VARCHAR(36) NOT NULL,
  `AttemptNumber` INT NOT NULL,
  `ActivityId` VARCHAR(36) DEFAULT NULL,
  `Timestamp` DATETIME DEFAULT NULL,
  `Response` VARCHAR(1000) DEFAULT NULL,
  `Result` VARCHAR(100) DEFAULT NULL,
  `NumericResult` FLOAT DEFAULT NULL,
  `TimeSpent` FLOAT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`VisitId`, `InteractionId`, `AttemptNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
