DROP TABLE IF EXISTS `SCORMActivity`;

CREATE TABLE `SCORMActivity` (
  `ActivityId` VARCHAR(16) NOT NULL,
  `ScormObjectId` VARCHAR(16) NOT NULL,
  `ParentActivityId` VARCHAR(16) DEFAULT NULL,
  `NumChildren` INT NOT NULL,
  `InternalId` VARCHAR(255) DEFAULT NULL,
  `Title` VARCHAR(200) DEFAULT NULL,
  `CompletionThreshold` FLOAT DEFAULT NULL,
  `PassingScore` FLOAT DEFAULT NULL,
  `PassingScoreUsed` TINYINT DEFAULT NULL,
  `ScoreMin` FLOAT DEFAULT NULL,
  `ScoreMax` FLOAT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`ActivityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
