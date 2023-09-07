DROP TABLE IF EXISTS `OutcomeAssessedCheckpoint`;

CREATE TABLE `OutcomeAssessedCheckpoint` (
  `CheckpointId` VARCHAR(16) NOT NULL,
  `DemonstrationId` VARCHAR(16) NOT NULL,
  `Feedback` VARCHAR(1000) NOT NULL,
  `ConfigDecayRate` INT NOT NULL,
  `ConfigAggregationMethod` INT NOT NULL,
  `ConfigIncludedActivities` INT NOT NULL,
  `ConfigMultipleAttemptStrategy` INT NOT NULL,
  `ConfigRecentlyAssessedActivityCount` INT NOT NULL,
  `ConfigTieBreaker` INT NOT NULL,
  `LastModifiedDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT NOT NULL,
  UNIQUE KEY (`CheckpointId`, `DemonstrationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
