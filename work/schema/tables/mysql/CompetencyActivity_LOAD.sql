DROP TABLE IF EXISTS `CompetencyActivity_LOAD`;

CREATE TABLE `CompetencyActivity_LOAD` (
  `ActivityId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `ActivityName` VARCHAR(256) DEFAULT NULL,
  `ActivityTypeId` INT DEFAULT NULL,
  `AssessmentType` VARCHAR(7) DEFAULT NULL,
  `ObjectLookupId` BIGINT DEFAULT NULL,
  `RubricId` BIGINT DEFAULT NULL,
  `LevelId` BIGINT DEFAULT NULL,
  `RubricCriterionId` BIGINT DEFAULT NULL,
  `AssessmentThresholdCriteria` VARCHAR(2) DEFAULT NULL,
  `AssessmentThreshold` DECIMAL(19, 9) DEFAULT NULL,
  `IsAutoEval` TINYINT DEFAULT NULL,
  `RubricName` VARCHAR(256) DEFAULT NULL,
  `RubricLevelRequired` VARCHAR(256) DEFAULT NULL,
  `ObjectId` BIGINT DEFAULT NULL,
  `ActivityType` VARCHAR(50) DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`ActivityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
