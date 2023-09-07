DROP TABLE IF EXISTS `CompetencyActivity`;

CREATE TABLE `CompetencyActivity` (
  `ActivityId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `ActivityName` VARCHAR(256) NOT NULL,
  `ActivityTypeId` INT NOT NULL,
  `AssessmentType` VARCHAR(7) NOT NULL,
  `ObjectLookupId` BIGINT NOT NULL,
  `RubricId` BIGINT DEFAULT NULL,
  `LevelId` BIGINT DEFAULT NULL,
  `RubricCriterionId` BIGINT NOT NULL,
  `AssessmentThresholdCriteria` VARCHAR(2) DEFAULT NULL,
  `AssessmentThreshold` DECIMAL(19, 9) DEFAULT NULL,
  `IsAutoEval` TINYINT NOT NULL,
  `RubricName` VARCHAR(256) DEFAULT NULL,
  `RubricLevelRequired` VARCHAR(256) DEFAULT NULL,
  `ObjectId` BIGINT DEFAULT NULL,
  `ActivityType` VARCHAR(50) DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`ActivityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
