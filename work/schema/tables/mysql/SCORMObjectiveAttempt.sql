DROP TABLE IF EXISTS `SCORMObjectiveAttempt`;

CREATE TABLE `SCORMObjectiveAttempt` (
  `VisitId` VARCHAR(16) NOT NULL,
  `ObjectiveId` VARCHAR(16) NOT NULL,
  `AttemptNumber` INT NOT NULL,
  `Score` FLOAT DEFAULT NULL,
  `ScoreRaw` FLOAT DEFAULT NULL,
  `Success` VARCHAR(100) DEFAULT NULL,
  `Completion` VARCHAR(100) DEFAULT NULL,
  `Progress` FLOAT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`VisitId`, `ObjectiveId`, `AttemptNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

