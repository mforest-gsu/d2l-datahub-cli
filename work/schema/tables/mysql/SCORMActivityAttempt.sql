DROP TABLE IF EXISTS `SCORMActivityAttempt`;

CREATE TABLE `SCORMActivityAttempt` (
  `VisitId` VARCHAR(16) NOT NULL,
  `ActivityId` VARCHAR(16) NOT NULL,
  `AttemptNumber` INT NOT NULL,
  `Completion` VARCHAR(100) DEFAULT NULL,
  `Success` VARCHAR(100) DEFAULT NULL,
  `Score` FLOAT DEFAULT NULL,
  `ScoreRaw` FLOAT DEFAULT NULL,
  `TimeSpent` FLOAT DEFAULT NULL,
  `Progress` FLOAT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`VisitId`, `ActivityId`, `AttemptNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
